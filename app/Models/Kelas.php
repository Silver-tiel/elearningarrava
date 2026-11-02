<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    public const HARI = [
        1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis',
        5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu',
    ];

    protected $fillable = ['nama', 'id_jenjang', 'tahun_ajaran', 'aktif', 'hari', 'berlaku_dari', 'berlaku_sampai', 'jam_batas'];

    protected $casts = [
        'aktif' => 'boolean',
        'berlaku_dari' => 'date',
        'berlaku_sampai' => 'date',
    ];

    /** Hari aktif sebagai array angka ISO. Kosong = setiap hari. */
    public function hariAktif(): array
    {
        return array_values(array_unique(array_filter(
            array_map('intval', explode(',', (string) $this->hari)),
            fn ($h) => $h >= 1 && $h <= 7
        )));
    }

    /**
     * Apakah kelas ini aktif pada tanggal tersebut?
     * Syarat: status aktif, dalam masa berlaku (jika diisi), dan hari termasuk jadwal (jika diisi).
     */
    public function aktifPadaTanggal(\Carbon\CarbonInterface $tanggal): bool
    {
        if (!$this->aktif) {
            return false;
        }

        $tgl = $tanggal->toDateString();

        if ($this->berlaku_dari && $tgl < $this->berlaku_dari->toDateString()) {
            return false;
        }

        if ($this->berlaku_sampai && $tgl > $this->berlaku_sampai->toDateString()) {
            return false;
        }

        $hari = $this->hariAktif();

        return empty($hari) || in_array($tanggal->dayOfWeekIso, $hari, true);
    }

    /** Batas tepat waktu pada tanggal tertentu (null jika tidak diatur). */
    public function batasPada(\Carbon\CarbonInterface $tanggal): ?\Illuminate\Support\Carbon
    {
        if (empty($this->jam_batas)) {
            return null;
        }

        return \Illuminate\Support\Carbon::parse($tanggal->toDateString() . ' ' . $this->jam_batas);
    }

    public function aktifHariIni(): bool
    {
        return $this->aktifPadaTanggal(now());
    }

    /** Teks ringkas jadwal untuk ditampilkan. */
    public function ringkasJadwal(): string
    {
        $hari = $this->hariAktif();
        $teks = empty($hari) ? 'Setiap hari' : implode(', ', array_map(fn ($h) => self::HARI[$h], $hari));

        if ($this->berlaku_dari || $this->berlaku_sampai) {
            $dari = $this->berlaku_dari ? $this->berlaku_dari->format('d M Y') : '…';
            $sampai = $this->berlaku_sampai ? $this->berlaku_sampai->format('d M Y') : '…';
            $teks .= " · {$dari} – {$sampai}";
        }

        if (!empty($this->jam_batas)) {
            $teks .= ' · batas ' . substr($this->jam_batas, 0, 5);
        }

        return $teks;
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    /**
     * Peserta kelas = semua siswa AKTIF pada jenjang yang sama dengan kelas ini.
     * Tidak ada pendaftaran per siswa; siswa baru pada jenjang itu otomatis ikut.
     * Kelas tanpa jenjang tidak memiliki peserta.
     */
    public function anggota()
    {
        $query = User::query()->where('id_tipeuser', 3);

        if (empty($this->id_jenjang)) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('id_jenjang', $this->id_jenjang)
            ->where(function ($w) {
                $w->whereNull('status_akun')->orWhere('status_akun', '!=', 'Nonaktif');
            });
    }

    public function punyaPeserta(User $siswa): bool
    {
        return !empty($this->id_jenjang)
            && $siswa->id_tipeuser == 3
            && (int) $siswa->id_jenjang === (int) $this->id_jenjang;
    }

    public function guru()
    {
        return $this->belongsToMany(User::class, 'kelas_guru', 'id_kelas', 'id_guru', 'id_kelas', 'id_user')
            ->withTimestamps();
    }

    public function sesi()
    {
        return $this->hasMany(SesiPresensi::class, 'id_kelas', 'id_kelas');
    }
}
