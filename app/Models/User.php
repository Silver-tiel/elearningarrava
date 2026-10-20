<?php

namespace App\Models;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    public $timestamps = true;

    protected ?array $memoizedRankTier = null;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'nisn',
        'nomor_hp',
        'kelas',
        'asal_sekolah',
        'id_tipeuser',
        'id_jenjang',
        'total_poin',
        'status_akun',
        'id_modul',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function jenjang(): BelongsTo
    {
        // Hubungkan ke Model Jenjang, bukan User
        return $this->belongsTo(Jenjang::class, 'id_jenjang');
    }

    public function tipeUser(): BelongsTo
    {
        // Hubungkan ke Model TipeUser (atau nama model tipe user kamu), bukan User
        return $this->belongsTo(TipeUser::class, 'id_tipeuser');
    }

    public function pencapaianUsers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PencapaianUser::class, 'id_user', 'id_user');
    }

    /**
     * Informasi status rank (tier penghargaan) dan progres EXP siswa berdasarkan total_poin.
     */
    public function getRankTierInfo(bool $forceRefresh = false): array
    {
        if (!$forceRefresh && $this->memoizedRankTier !== null) {
            return $this->memoizedRankTier;
        }

        $points = (int) ($this->total_poin ?? 0);

        if (!Schema::hasTable('achievements')) {
            return $this->memoizedRankTier = [
                'current_rank' => 'Pemula',
                'current_badge_url' => null,
                'next_rank' => null,
                'next_badge_url' => null,
                'current_points' => $points,
                'next_points' => null,
                'points_needed' => 0,
                'percent' => 100,
                'is_max' => true,
                'tier_min_points' => 0,
            ];
        }

        $tiers = Achievement::where('is_active', true)
            ->orderBy('minimal_poin_achivement', 'asc')
            ->get();

        if ($tiers->isEmpty()) {
            return $this->memoizedRankTier = [
                'current_rank' => 'Pemula',
                'current_badge_url' => null,
                'next_rank' => null,
                'next_badge_url' => null,
                'current_points' => $points,
                'next_points' => null,
                'points_needed' => 0,
                'percent' => 100,
                'is_max' => true,
                'tier_min_points' => 0,
            ];
        }

        $unlocked = $tiers->filter(fn ($t) => (int) $t->minimal_poin_achivement <= $points);
        $locked = $tiers->filter(fn ($t) => (int) $t->minimal_poin_achivement > $points);

        $currentTier = $unlocked->last();
        $nextTier = $locked->first();

        $currentMinPoints = $currentTier ? (int) $currentTier->minimal_poin_achivement : 0;
        $currentRankName = $currentTier ? $currentTier->nama_achivement : 'Pemula';
        $currentBadgeUrl = $currentTier ? $currentTier->gambar_url : null;

        if (!$nextTier) {
            // Siswa sudah mencapai tingkat penghargaan tertinggi
            return $this->memoizedRankTier = [
                'current_rank' => $currentRankName,
                'current_badge_url' => $currentBadgeUrl,
                'next_rank' => null,
                'next_badge_url' => null,
                'current_points' => $points,
                'next_points' => null,
                'points_needed' => 0,
                'percent' => 100,
                'is_max' => true,
                'tier_min_points' => $currentMinPoints,
            ];
        }

        $nextPoints = (int) $nextTier->minimal_poin_achivement;
        $pointsNeeded = max(0, $nextPoints - $points);
        $span = max(1, $nextPoints - $currentMinPoints);
        $earnedInBracket = max(0, $points - $currentMinPoints);
        $percent = (int) round(($earnedInBracket / $span) * 100);
        $percent = max(0, min(100, $percent));

        return $this->memoizedRankTier = [
            'current_rank' => $currentRankName,
            'current_badge_url' => $currentBadgeUrl,
            'next_rank' => $nextTier->nama_achivement,
            'next_badge_url' => $nextTier->gambar_url,
            'current_points' => $points,
            'next_points' => $nextPoints,
            'points_needed' => $pointsNeeded,
            'percent' => $percent,
            'is_max' => false,
            'tier_min_points' => $currentMinPoints,
        ];
    }

    /**
     * Accessor: $user->rank_tier
     */
    public function getRankTierAttribute(): array
    {
        return $this->getRankTierInfo();
    }

    public function refreshRankTier(): array
    {
        $this->memoizedRankTier = null;
        return $this->getRankTierInfo(true);
    }
}