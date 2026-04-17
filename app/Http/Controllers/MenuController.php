<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $menus = Menu::with('category')
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($query) use ($search) {
                          $query->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('menus.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Bersihkan titik ribuan
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'discount_amount' => str_replace('.', '', $request->discount_amount),
        ]);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_type' => 'nullable|in:percent,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount ?: 0,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::latest()->get();
        return view('menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        // Bersihkan titik ribuan
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'discount_amount' => str_replace('.', '', $request->discount_amount),
        ]);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_type' => 'nullable|in:percent,fixed',
            'discount_amount' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $menu->image;

        if ($request->hasFile('image')) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }

            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount ?: 0,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}