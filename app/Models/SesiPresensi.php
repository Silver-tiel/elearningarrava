<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_sesi
 * @property int $id_kelas
 * @property int $id_guru
 * @property string $judul
 * @property int $pertemuan_ke
 * @property \Illuminate\Support\Carbon|null $tanggal
 * @property \Illuminate\Support\Carbon|null $batas_tepat_waktu
 * @property string $status
 * @property string|null $kunci_otomatis
 * @property int|null $presensi_count
 * @property-read \App\Models\Kelas|null $kelas
 * @property-read \App\Models\User|null $guru
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Presensi[] $presensi
 */
class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';
    protected $primaryKey = 'id_sesi';

    protected $fillable = [
        'id_kelas', 'id_guru', 'judul', 'pertemuan_ke', 'tanggal', 'batas_tepat_waktu', 'status', 'kunci_otomatis',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'batas_tepat_waktu' => 'datetime',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_guru', 'id_user');
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'id_sesi', 'id_sesi');
    }

    public function isBuka(): bool
    {
        return $this->status === 'buka';
    }

    public function isHariIni(): bool
    {
        return $this->tanggal !== null && $this->tanggal->isToday();
    }

    /** Sesi hanya berlaku pada tanggalnya; lewat hari = kedaluwarsa (data tetap tersimpan). */
    public function kedaluwarsa(): bool
    {
        return $this->tanggal !== null && $this->tanggal->lt(now()->startOfDay());
    }

    /**
     * Boleh dipindai: masih dibuka, masih pada tanggal sesi, DAN kelasnya masih aktif
     * pada tanggal itu (status aktif, masa berlaku, jadwal hari).
     */
    public function bisaDipindai(): bool
    {
        return $this->isBuka()
            && $this->isHariIni()
            && $this->kelas !== null
            && $this->kelas->aktifPadaTanggal($this->tanggal);
    }

    /**
     * Pastikan sesi presensi untuk kelas pada tanggal tertentu ADA (dibuat otomatis).
     * Hanya dibuat jika kelas aktif pada tanggal itu; tidak pernah menggandakan sesi
     * (termasuk sesi lama yang dibuat manual pada tanggal yang sama).
     */
    public static function pastikanUntuk(Kelas $kelas, \Carbon\CarbonInterface $tanggal, int $idPembuat): ?self
    {
        if (!$kelas->aktifPadaTanggal($tanggal)) {
            return null;
        }

        $tgl = $tanggal->toDateString();

        $ada = static::where('id_kelas', $kelas->id_kelas)->whereDate('tanggal', $tgl)->orderBy('id_sesi')->first();
        if ($ada) {
            return $ada;
        }

        $kunci = $kelas->id_kelas . ':' . $tgl;
        $hari = $tanggal->copy()->locale('id')->translatedFormat('l, d F Y');

        try {
            return static::create([
                'id_kelas' => $kelas->id_kelas,
                'id_guru' => $idPembuat,
                'judul' => 'Presensi ' . $hari,
                'pertemuan_ke' => ((int) static::where('id_kelas', $kelas->id_kelas)->max('pertemuan_ke')) + 1,
                'tanggal' => $tgl,
                'batas_tepat_waktu' => $kelas->batasPada($tanggal),
                'status' => 'buka',
                'kunci_otomatis' => $kunci,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Dibuat bersamaan oleh permintaan lain: pakai yang sudah ada.
            $sudah = static::where('kunci_otomatis', $kunci)->first();
            if (!$sudah) {
                throw $e;
            }

            return $sudah;
        }
    }

    /** dibuka | ditutup | kedaluwarsa */
    public function statusTampil(): string
    {
        if (!$this->isBuka()) {
            return 'ditutup';
        }

        return $this->kedaluwarsa() ? 'kedaluwarsa' : 'dibuka';
    }
}
