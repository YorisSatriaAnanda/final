@extends('layouts.admin')

@section('content')

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Kategori</h1>
        <p class="text-gray-500 mt-1">Tambahkan kategori baru untuk menu coffee shop.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl bg-red-100 text-red-700 px-5 py-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-md p-8 max-w-2xl">
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Coffee"
                       class="w-full rounded-2xl border border-gray-200 px-5 py-4 focus:ring-2 focus:ring-red-500 focus:outline-none">
            </div>

            <div class="flex gap-3">
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-200 text-gray-800 px-6 py-3 rounded-2xl hover:bg-gray-300 transition">
                    Kembali
                </a>

                <button class="bg-red-700 text-white px-6 py-3 rounded-2xl hover:bg-red-800 transition shadow-md">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>

@endsection