<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnFormatting,
    WithStyles
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

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->id_user,
            $siswa->nama,
            (string) ($siswa->nisn ?? '-'),
            $siswa->email,
            $siswa->jenjang->nama_tipe
                ?? $siswa->kelas
                ?? 'Umum',
            $siswa->tingkatKelas->nama ?? '-',
            ($siswa->status_akun ?? 'Aktif'),
            $siswa->created_at
                ? $siswa->created_at->format('d-m-Y')
                : '-',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '2563EB'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
        ];
    }
}
