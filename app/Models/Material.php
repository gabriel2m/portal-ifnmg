<?php

namespace App\Models;

use App\Enums\TipoMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property TipoMaterial $tipo
 * @property integer $catmat
 * @property integer $unidade_id
 * @property Unidade $unidade
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiais';

    protected $guarded = [];

    protected $casts = [
        'tipo' => TipoMaterial::class,
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class)->withTrashed();
    }
}
