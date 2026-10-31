<?php

namespace App\Providers;

use App\Models\Modul;
use App\Models\Quiz;
use App\Models\SesiPresensi;
use App\Models\Soal;
use App\Models\User;
use App\Policies\ModulPolicy;
use App\Policies\QuizPolicy;
use App\Policies\SesiPresensiPolicy;
use App\Policies\SoalPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Modul::class, ModulPolicy::class);
        Gate::policy(Quiz::class, QuizPolicy::class);
        Gate::policy(Soal::class, SoalPolicy::class);
        Gate::policy(SesiPresensi::class, SesiPresensiPolicy::class);

        // Pengelolaan user, role, kelas, penugasan, QR: hanya admin.
        Gate::define('kelola-sistem', fn (User $user) => $user->isAdmin());

        // QR hanya boleh dilihat/diunduh oleh siswa pemiliknya sendiri.
        Gate::define('lihat-qr', fn (User $user, User $siswa) =>
            $user->isSiswa() && (int) $user->id_user === (int) $siswa->id_user
        );

        Gate::define('regenerate-qr', fn (User $user) => $user->isAdmin());

        // Rate limit endpoint scan QR (brute force). Batas kegagalan dipasang di controller.
        RateLimiter::for('scan-qr', function (Request $request) {
            return [
                Limit::perMinute(60)->by('scan-user:' . ($request->user()?->id_user ?? 'tamu')),
                Limit::perMinute(120)->by('scan-ip:' . $request->ip()),
            ];
        });
    }
}
