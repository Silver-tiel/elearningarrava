<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Digunakan untuk query jika belum ada Model khusus

class SiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil data siswa yang sedang login
        $user = Auth::user();

        // 2. Ambil data statistik dari database
        // (Contoh query real dari DB - sesuaikan nama tabel/kolom dengan database Anda)
        $totalXp = DB::table('xp_log')->where('id_user', $user->id_user)->sum('point') ?? 0;
        $hariStreak = DB::table('streaks')->where('id_user', $user->id_user)->value('total_days') ?? 0;
        
        // 3. Ambil daftar Modul Pelajaran
        $modulPelajaran = DB::table('modul')
                            ->join('guru', 'modul.id_guru', '=', 'guru.id_guru')
                            ->select('modul.*', 'guru.nama as nama_guru')
                            ->limit(3)
                            ->get();

        // 4. Ambil daftar Tugas / Latihan Soal Aktif
        $latihanSoal = DB::table('tugas')
                        ->where('id_user', $user->id_user)
                        ->where('status', 'belum_selesai')
                        ->orderBy('deadline', 'asc')
                        ->limit(3)
                        ->get();

        // 5. Ambil data Progress Kelas/Materi Aktif
        $materiAktif = DB::table('progress_belajar')
                        ->where('id_user', $user->id_user)
                        ->latest('updated_at')
                        ->first();

        // Kirim data ke view dashboard_siswa
        return view('dashboard_siswa', compact(
            'user', 
            'totalXp', 
            'hariStreak', 
            'modulPelajaran', 
            'latihanSoal', 
            'materiAktif'
        ));
    }
}