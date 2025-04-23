@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-6xl">

    <h1 class="text-3xl font-semibold mb-6 text-gray-800">📋 Daftar Tugas Harian</h1>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow mb-5">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="flex justify-between items-center mb-6">
        <form method="GET" class="flex items-center gap-3">
            <label for="status" class="text-gray-600 text-sm">Filter Status:</label>
            <select name="status" onchange="this.form.submit()" class="border border-gray-300 p-2 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-blue-200">
                <option value="semua" {{ request('status') === 'semua' ? 'selected' : '' }}>Semua</option>
                <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>

        <!-- Tombol tambah -->
        <a href="{{ route('tugas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
            + Tambah Tugas
        </a>
    </div>

    <!-- Progress bar -->
    <div class="mb-6">
        <div class="flex justify-between text-sm mb-1 text-gray-600">
            <span>Progress</span>
            <span>{{ $selesai }} / {{ $total }} selesai</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
            <div class="bg-green-500 h-full transition-all duration-300" style="width: {{ $progress }}%"></div>
        </div>
    </div>

    <!-- Tabel tugas -->
    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Deadline</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $item->judul_tugas }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->deskripsi }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium text-white 
                                {{ $item->status === 'selesai' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-2 justify-center">
                            @if($item->status === 'belum')
                                <form method="POST" action="{{ route('tugas.selesaikan', $item->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-xs shadow" onclick="return confirm('Tandai selesai?')">
                                        ✅
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('tugas.edit', $item->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs shadow">✏️</a>
                            <form action="{{ route('tugas.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs shadow">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Tidak ada tugas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
