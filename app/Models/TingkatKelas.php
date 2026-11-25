<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id_tingkat
 * @property int $id_jenjang
 * @property string $nama
 * @property int $urutan
 * @property bool $aktif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Jenjang|null $jenjang
 */
class TingkatKelas extends Model
{
    protected $table = 'tingkat_kelas';
    protected $primaryKey = 'id_tingkat';
    public $timestamps = true;

    protected $fillable = [
        'id_jenjang',
        'nama',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
        'id_jenjang' => 'integer',
    ];

    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class, 'id_jenjang', 'id_jenjang');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_tingkat_kelas', 'id_tingkat');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'id_tingkat_kelas', 'id_tingkat');
    }

    public function moduls(): HasMany
    {
        return $this->hasMany(Modul::class, 'id_tingkat_kelas', 'id_tingkat');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function scopeUntukJenjang($query, $idJenjang)
    {
        return $query->where('id_jenjang', $idJenjang);
    }
}
