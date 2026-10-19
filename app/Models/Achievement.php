<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    protected $table = 'achievements';
    protected $primaryKey = 'id_achievement';
    public $timestamps = true;

    protected $fillable = [
        'nama_achivement',
        'minimal_poin_achivement',
        'gambar_achivement',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'minimal_poin_achivement' => 'integer',
        'is_active' => 'boolean',
    ];

    public function pencapaianUsers(): HasMany
    {
        return $this->hasMany(PencapaianUser::class, 'id_achievement', 'id_achievement');
    }

    /**
     * URL gambar achievement dari storage publik
     */
    public function getGambarUrlAttribute(): ?string
    {
        if ($this->gambar_achivement && Storage::disk('public')->exists($this->gambar_achivement)) {
            return Storage::url($this->gambar_achivement);
        }

        return null;
    }

    /**
     * Sinkronisasi achievement untuk seorang siswa berdasarkan total_poin.
     */
    public static function syncForUser(User $user): void
    {
        if ((int) $user->id_tipeuser !== 3 || !\Illuminate\Support\Facades\Schema::hasTable('achievements')) {
            return;
        }

        $userPoints = (int) ($user->total_poin ?? 0);

        $eligibleAchievements = self::where('is_active', true)
            ->where('minimal_poin_achivement', '<=', $userPoints)
            ->get();

        foreach ($eligibleAchievements as $achievement) {
            PencapaianUser::firstOrCreate(
                [
                    'id_user' => $user->id_user,
                    'id_achievement' => $achievement->id_achievement,
                ],
                [
                    'nama' => $achievement->nama_achivement,
                    'waktu_pencapaian' => now(),
                ]
            );
        }
    }

    /**
     * Berikan achievement ini ke semua siswa yang sudah mencapai minimal poin.
     */
    public function syncToEligibleUsers(): int
    {
        if (!$this->is_active) {
            return 0;
        }

        $qualifyingUsers = User::where('id_tipeuser', 3)
            ->where('total_poin', '>=', $this->minimal_poin_achivement)
            ->get();

        $count = 0;
        foreach ($qualifyingUsers as $user) {
            $created = PencapaianUser::firstOrCreate(
                [
                    'id_user' => $user->id_user,
                    'id_achievement' => $this->id_achievement,
                ],
                [
                    'nama' => $this->nama_achivement,
                    'waktu_pencapaian' => now(),
                ]
            );

            if ($created->wasRecentlyCreated) {
                $count++;
            }
        }

        return $count;
    }
}
