<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * Menampilkan halaman kasir dengan filter kategori dan pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category_id;

        $categories = Category::latest()->get();

        $menus = Menu::with('category')
            ->where('is_active', true)
            ->where('is_available', true)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->get();

        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('cashier.index', compact(
            'menus',
            'categories',
            'cart',
            'subtotal',
            'search',
            'categoryId'
        ));
    }

    /**
     * Menambahkan menu ke keranjang belanja (Session).
     */
    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);

        if (!$menu->is_active || !$menu->is_available || $menu->stock <= 0) {
            return back()->with('error', 'Menu tidak tersedia.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $menu->stock) {
                $cart[$id]['qty']++;
            } else {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
        } else {
            $cart[$id] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->final_price,
                'image' => $menu->image,
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Menu ditambahkan ke keranjang.');
    }

    /**
     * Menambah jumlah qty di keranjang.
     */
    public function increaseQty($id)
    {
        $cart = session()->get('cart', []);
        $menu = Menu::findOrFail($id);

        if (isset($cart[$id])) {
            if ($cart[$id]['qty'] < $menu->stock) {
                $cart[$id]['qty']++;
                session()->put('cart', $cart);
            } else {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
        }

        return back();
    }

    /**
     * Mengurangi jumlah qty di keranjang.
     */
    public function decreaseQty($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;
            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return back();
    }

    /**
     * Menghapus item tertentu dari keranjang.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }

    /**
     * Mengosongkan seluruh keranjang.
     */
    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    /**
     * Proses transaksi, simpan ke database, dan kurangi stok.
     */
    public function checkout(Request $request)
    {
        // Bersihkan titik ribuan
        $request->merge([
            'paid_amount' => str_replace('.', '', $request->paid_amount),
            'discount_value' => str_replace('.', '', $request->discount_value),
        ]);

        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,qris,debit,transfer',
            'paid_amount' => 'required|integer|min:0',
            'discount_value' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fixed,percent',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        
        $discountValue = $request->discount_value ?? 0;
        $discountType = $request->discount_type ?? 'fixed';
        
        if ($discountType === 'percent') {
            $discountAmount = ($subtotal * $discountValue) / 100;
        } else {
            $discountAmount = $discountValue;
        }

        $totalPrice = $subtotal - $discountAmount;

        if ($request->paid_amount < $totalPrice) {
            return back()->with('error', 'Uang bayar kurang dari total belanja.');
        }

        DB::beginTransaction();

        try {
            $invoiceCode = 'INV-' . now()->format('YmdHis') . '-' . rand(100, 999);

            $order = Order::create([
                'invoice_code'   => $invoiceCode,
                'customer_name'  => $request->customer_name,
                'total_price'    => $totalPrice,
                'discount'       => $discountAmount,
                'discount_type'  => $discountType,
                'discount_value' => $discountValue,
                'payment_method' => $request->payment_method,
                'paid_amount'    => $request->paid_amount,
                'change_amount'  => $request->paid_amount - $totalPrice,
                'status'         => 'paid',
                'notes'          => $request->notes,
            ]);

            foreach ($cart as $item) {
                $menu = Menu::findOrFail($item['id']);

                if ($menu->stock < $item['qty']) {
                    throw new \Exception("Stok menu {$menu->name} tidak mencukupi.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'qty'      => $item['qty'],
                    'price'    => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Update stok dengan refresh agar data sinkron
                $menu->decrement('stock', $item['qty']);
                $menu->refresh();

                if ($menu->stock <= 0) {
                    $menu->update(['is_available' => false]);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('cashier.order.show', $order)->with('success', 'Pembayaran berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pesanan (Struk/Invoice).
     */
    public function showOrder(Order $order)
    {
        $order->load('items.menu');
        return view('cashier.show', compact('order'));
    }
}