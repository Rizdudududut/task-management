<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    // Menampilkan daftar tugas
    public function index(Request $request)
    {
        $query = Tugas::query();

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan deadline terdekat
        $tugas = $query->orderBy('deadline')->get();

        // Data untuk progress bar
        $total = Tugas::count();
        $selesai = Tugas::where('status', 'selesai')->count();
        $progress = $total > 0 ? ($selesai / $total) * 100 : 0;

        return view('tugas.index', compact('tugas', 'progress', 'total', 'selesai'));
    }

    // Form tambah tugas
    public function create()
    {
        return view('tugas.create');
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'judul_tugas' => 'required',
            'deadline' => 'required|date',
        ]);

        Tugas::create([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'status' => 'belum',
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    // Form edit tugas
    public function edit(Tugas $tuga)
    {
        return view('tugas.edit', compact('tuga'));
    }

    // Simpan update tugas
    public function update(Request $request, Tugas $tuga)
    {
        $request->validate([
            'judul_tugas' => 'required',
            'deadline' => 'required|date',
        ]);

        $tuga->update($request->all());

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    // Hapus tugas
    public function destroy(Tugas $tuga)
    {
        $tuga->delete();
        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

    // Tandai tugas sebagai selesai
    public function selesaikan($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->status = 'selesai';
        $tugas->save();

        return redirect()->route('tugas.index')->with('success', 'Tugas ditandai sebagai selesai!');
    }
}