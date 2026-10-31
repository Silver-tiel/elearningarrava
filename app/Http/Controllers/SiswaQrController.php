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
        return redirect()->to(route('siswa.profil') . '#kartu-qr');
    }
}
