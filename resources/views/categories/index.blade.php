@extends('layouts.admin')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kategori Menu</h1>
            <p class="text-gray-500 mt-1">Kelola kategori menu coffee shop kamu.</p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="bg-red-700 text-white px-5 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">Daftar Kategori</h2>
            <form action="{{ route('categories.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari kategori..."
                       class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all w-full md:w-64">
                <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 group-focus-within:text-red-500 transition-colors"></i>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#fafafa]">
                    <tr class="text-left text-gray-500">
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Kategori</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-t hover:bg-red-50/30 transition">
                            <td class="px-4 py-2 font-medium text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 font-semibold text-gray-900">{{ $category->name }}</td>
                            <td class="px-4 py-2">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="bg-yellow-400 text-white px-4 py-2 rounded-xl hover:bg-yellow-500 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-gray-500 italic">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    </div>

@endsection