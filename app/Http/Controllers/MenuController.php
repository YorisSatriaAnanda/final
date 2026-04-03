<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu dengan relasi kategori.
     */
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        return view('menus.index', compact('menus'));
    }

    /**
     * Menampilkan form tambah menu dengan data kategori.
     */
    public function create()
    {
        $categories = Category::all();
        return view('menus.create', compact('categories'));
    }

    /**
     * Menyimpan menu baru beserta upload gambar.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'slug'           => Str::slug($request->name . '-' . time()),
            'description'    => $request->description,
            'price'          => $request->price,
            'image'          => $imagePath,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan');
    }

    /**
     * Menampilkan detail menu (opsional).
     */
    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    /**
     * Menampilkan form edit menu.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('menus.edit', compact('menu', 'categories'));
    }

    /**
     * Memperbarui data menu dan mengelola file gambar.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $menu->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada gambar baru yang diupload
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'slug'           => Str::slug($request->name . '-' . time()),
            'description'    => $request->description,
            'price'          => $request->price,
            'image'          => $imagePath,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate');
    }

    /**
     * Menghapus menu dan file gambarnya.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus');
    }
}