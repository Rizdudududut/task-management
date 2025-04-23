<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TugasController;

Route::get('/', function () {
    return redirect()->route('tugas.index');
});

Route::resource('tugas', TugasController::class);

Route::patch('tugas/{id}/selesaikan', [TugasController::class, 'selesaikan'])->name('tugas.selesaikan');