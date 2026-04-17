@extends('layouts.admin')

@section('content')

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Ulasan</h1>
            <p class="text-gray-500 mt-1">Dengarkan apa kata pelanggan Anda.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-green-100 text-green-700 px-5 py-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[30px] shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">Daftar Ulasan</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#fafafa]">
                    <tr class="text-left text-gray-500">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Ulasan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $review->name }}</div>
                                <div class="text-xs text-gray-500 italic">{{ $review->email ?? 'Tanpa Email' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700 text-sm max-w-sm line-clamp-3">"{{ $review->message }}"</p>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $review->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-50 text-red-600 px-4 py-2 rounded-xl hover:bg-red-600 hover:text-white transition flex items-center gap-2 text-sm font-semibold">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                                Belum ada ulasan dari pelanggan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>

@endsection
