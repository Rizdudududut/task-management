@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Tambah Tugas Baru</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
            <ul class="list-disc px-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tugas.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Judul Tugas</label>
            <input type="text" name="judul_tugas" class="border rounded w-full p-2" required>
        </div>

        <div>
            <label class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="border rounded w-full p-2"></textarea>
        </div>

        <div>
            <label class="block font-semibold">Deadline</label>
            <input type="date" name="deadline" class="border rounded w-full p-2" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('tugas.index') }}" class="text-gray-600 ml-2">Kembali</a>
    </form>
</div>
@endsection
