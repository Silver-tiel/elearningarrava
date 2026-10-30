<?php

namespace App\Http\Controllers;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Gate;

/** Siswa melihat/mengunduh/mencetak QR miliknya sendiri. */
class SiswaQrController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // Hanya pemilik QR yang boleh melihatnya (tidak ada parameter id => tidak ada IDOR).
        Gate::authorize('lihat-qr', $user);

        $renderer = new ImageRenderer(new RendererStyle(320, 1), new SvgImageBackEnd());
        $svg = (new Writer($renderer))->writeString($user->qrPayload());
        $svg = preg_replace('/^<\?xml.*?\?>\s*/s', '', $svg);

        $kelas = $user->kelasDiikuti()->orderBy('nama')->pluck('nama');

        return response()
            ->view('siswa.qr', [
                'svg' => $svg,
                'nama' => $user->nama,
                'kelas' => $kelas,
            ])
            ->header('Cache-Control', 'no-store, private');
    }
}
