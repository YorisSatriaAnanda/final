@extends('layouts.admin')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Ulasan Pelanggan</h1>
    <p class="text-gray-500 mt-1">Daftar ulasan dan pesan dari pelanggan.</p>
</div>

<div class="bg-white rounded-[30px] p-6 shadow-md mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500">
                    <th class="py-4 font-semibold">Tanggal</th>
                    <th class="py-4 font-semibold">Nama</th>
                    <th class="py-4 font-semibold">Email</th>
                    <th class="py-4 font-semibold">Pesan</th>
                </tr>
            </thead>
            <tbody>
                @if(count($reviews) > 0)
                    @foreach($reviews as $review)
                        <tr class="border-b last:border-0 hover:bg-gray-50 transition">
                            <td class="py-4 whitespace-nowrap">{{ $review->created_at->format('d M Y H:i') }}</td>
                            <td class="py-4 font-semibold text-gray-900">{{ $review->name }}</td>
                            <td class="py-4 text-gray-500">{{ $review->email ?? '-' }}</td>
                            <td class="py-4 text-gray-700 max-w-md break-words">{{ $review->message }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Belum ada ulasan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection
