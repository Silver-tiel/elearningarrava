<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SiswaExport
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query(): Builder
    {
        $query = User::query()
            ->where('id_tipeuser', 3)
            ->with(['jenjang', 'tingkatKelas']);

        if (!empty($this->filters['search'])) {
            $search = trim($this->filters['search']);

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['kelas'])) {
            $kelas = $this->filters['kelas'];

            if (strcasecmp($kelas, 'Umum') === 0) {
                $query->where(function ($q) {
                    $q->whereNull('id_jenjang')
                        ->orWhereHas('jenjang', function ($j) {
                            $j->whereRaw(
                                'LOWER(nama_tipe) = ?',
                                ['umum']
                            );
                        });
                });
            } else {
                $query->whereHas('jenjang', function ($q) use ($kelas) {
                    $q->where('nama_tipe', $kelas);
                });
            }
        }

        if (!empty($this->filters['status'])) {
            $status = $this->filters['status'];

            $query->where(function ($q) use ($status) {
                $q->where('status_akun', $status);

                if ($status === 'Aktif') {
                    $q->orWhereNull('status_akun');
                }
            });
        }

        return $query->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Siswa',
            'Nama Lengkap',
            'NISN',
            'Email',
            'Jenjang',
            'Tingkat Kelas',
            'Status Akun',
            'Tanggal Terdaftar',
        ];
    }

    public function map($siswa, int $no): array
    {
        return [
            $no,
            $siswa->id_user,
            $siswa->nama,
            (string) ($siswa->nisn ?? '-'),
            $siswa->email,
            $siswa->jenjang->nama_tipe ?? ($siswa->kelas ?? 'Umum'),
            $siswa->tingkatKelas->nama ?? ($siswa->tingkatKelas->nama_tingkat_kelas ?? '-'),
            $siswa->status_akun ?? 'Aktif',
            $siswa->created_at ? $siswa->created_at->format('d-m-Y') : '-',
        ];
    }
}
