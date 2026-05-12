@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Kategori</h1>
        <p class="text-gray-500 mt-1">Perbarui data kategori menu.</p>
    </div>



    <div class="bg-white rounded-[30px] shadow-md p-8 max-w-2xl">
        <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full rounded-2xl border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }} px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
                @error('name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3">
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Kembali
                </a>

                <button class="bg-yellow-500 text-white px-6 py-3 rounded-2xl hover:bg-yellow-600 transition shadow-md">
                    Update Kategori
                </button>
            </div>
        </form>
    </div>

@endsection