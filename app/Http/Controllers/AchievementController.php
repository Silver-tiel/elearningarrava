<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\PencapaianUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    /**
     * Menampilkan daftar achievement / penghargaan siswa.
     */
    public function index(Request $request)
    {
        $query = Achievement::query()->withCount('pencapaianUsers');

        // Pencarian berdasarkan nama atau deskripsi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_achivement', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter status aktif
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        // Urutan
        $sort = $request->input('sort', 'terbaru');
        match ($sort) {
            'poin_terendah' => $query->orderBy('minimal_poin_achivement', 'asc'),
            'poin_tertinggi' => $query->orderBy('minimal_poin_achivement', 'desc'),
            'nama_asc' => $query->orderBy('nama_achivement', 'asc'),
            'terlama' => $query->oldest('id_achievement'),
            default => $query->latest('id_achievement'),
        };

        $achievements = $query->paginate(9)->withQueryString();

        // Statistik ringkasan
        $totalAchievement = Achievement::count();
        $totalAktif = Achievement::where('is_active', true)->count();
        $totalDiberikan = PencapaianUser::whereNotNull('id_achievement')->count();
        $siswaPenerimaCount = PencapaianUser::distinct('id_user')->count('id_user');

        return view('admin.achievement.index', compact(
            'achievements',
            'totalAchievement',
            'totalAktif',
            'totalDiberikan',
            'siswaPenerimaCount'
        ));
    }

    /**
     * Menampilkan form pembuatan achievement baru.
     */
    public function create()
    {
        return view('admin.achievement.create');
    }

    /**
     * Menyimpan achievement baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_achivement' => ['required', 'string', 'max:255'],
            'minimal_poin_achivement' => ['required', 'integer', 'min:0'],
            'gambar_achivement' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'nama_achivement.required' => 'Nama achievement wajib diisi.',
            'nama_achivement.max' => 'Nama achievement maksimal 255 karakter.',
            'minimal_poin_achivement.required' => 'Minimal poin achievement wajib diisi.',
            'minimal_poin_achivement.integer' => 'Minimal poin harus berupa angka bulat.',
            'minimal_poin_achivement.min' => 'Minimal poin tidak boleh bernilai negatif.',
            'gambar_achivement.required' => 'Gambar achievement wajib diunggah.',
            'gambar_achivement.image' => 'File gambar achievement harus berupa gambar.',
            'gambar_achivement.mimes' => 'Format gambar harus JPEG, PNG, JPG, WebP, atau SVG.',
            'gambar_achivement.max' => 'Ukuran file gambar maksimal 2 MB.',
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar_achivement')) {
            $pathGambar = $request->file('gambar_achivement')->store('achievements', 'public');
        }

        $achievement = Achievement::create([
            'nama_achivement' => $validated['nama_achivement'],
            'minimal_poin_achivement' => $validated['minimal_poin_achivement'],
            'gambar_achivement' => $pathGambar,
            'deskripsi' => $request->input('deskripsi'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Otomatis berikan ke siswa yang sudah memenuhi syarat poin
        $penerimaAwal = $achievement->syncToEligibleUsers();

        $pesan = "Penghargaan \"{$achievement->nama_achivement}\" berhasil dibuat.";
        if ($penerimaAwal > 0) {
            $pesan .= " Diberikan otomatis kepada {$penerimaAwal} siswa yang telah memenuhi poin.";
        }

        return redirect()->route('admin.achievement')->with('success', $pesan);
    }

    /**
     * Menampilkan form edit achievement.
     */
    public function edit($id)
    {
        $achievement = Achievement::withCount('pencapaianUsers')->findOrFail($id);

        return view('admin.achievement.edit', compact('achievement'));
    }

    /**
     * Memperbarui data achievement.
     */
    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $validated = $request->validate([
            'nama_achivement' => ['required', 'string', 'max:255'],
            'minimal_poin_achivement' => ['required', 'integer', 'min:0'],
            'gambar_achivement' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'nama_achivement.required' => 'Nama achievement wajib diisi.',
            'nama_achivement.max' => 'Nama achievement maksimal 255 karakter.',
            'minimal_poin_achivement.required' => 'Minimal poin achievement wajib diisi.',
            'minimal_poin_achivement.integer' => 'Minimal poin harus berupa angka bulat.',
            'minimal_poin_achivement.min' => 'Minimal poin tidak boleh bernilai negatif.',
            'gambar_achivement.image' => 'File gambar achievement harus berupa gambar.',
            'gambar_achivement.mimes' => 'Format gambar harus JPEG, PNG, JPG, WebP, atau SVG.',
            'gambar_achivement.max' => 'Ukuran file gambar maksimal 2 MB.',
        ]);

        $oldImage = $achievement->gambar_achivement;
        if ($request->hasFile('gambar_achivement')) {
            $achievement->gambar_achivement = $request->file('gambar_achivement')->store('achievements', 'public');

            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        $achievement->nama_achivement = $validated['nama_achivement'];
        $achievement->minimal_poin_achivement = $validated['minimal_poin_achivement'];
        $achievement->deskripsi = $request->input('deskripsi');
        $achievement->is_active = $request->boolean('is_active', true);
        $achievement->save();

        // Update nama di pencapaianuser yang sudah ada
        PencapaianUser::where('id_achievement', $achievement->id_achievement)
            ->update(['nama' => $achievement->nama_achivement]);

        // Sinkronisasi siswa baru yang kini memenuhi syarat
        $penerimaBaru = $achievement->syncToEligibleUsers();

        $pesan = "Penghargaan \"{$achievement->nama_achivement}\" berhasil diperbarui.";
        if ($penerimaBaru > 0) {
            $pesan .= " Terdistribusi ke {$penerimaBaru} siswa tambahan yang memenuhi syarat.";
        }

        return redirect()->route('admin.achievement')->with('success', $pesan);
    }

    /**
     * Menghapus achievement beserta file gambarnya.
     */
    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $nama = $achievement->nama_achivement;

        if ($achievement->gambar_achivement && Storage::disk('public')->exists($achievement->gambar_achivement)) {
            Storage::disk('public')->delete($achievement->gambar_achivement);
        }

        $achievement->delete();

        return redirect()->route('admin.achievement')
            ->with('success', "Penghargaan \"{$nama}\" berhasil dihapus.");
    }

    /**
     * Sinkronisasi manual achievement ke seluruh siswa yang memenuhi syarat poin.
     */
    public function sync($id)
    {
        $achievement = Achievement::findOrFail($id);
        $penerimaBaru = $achievement->syncToEligibleUsers();

        return back()->with(
            'success',
            "Sinkronisasi selesai. {$penerimaBaru} siswa baru menerima penghargaan \"{$achievement->nama_achivement}\"."
        );
    }
}
