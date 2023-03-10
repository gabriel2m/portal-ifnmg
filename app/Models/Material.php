<?php

namespace App\Models;

use App\Enums\TipoMaterial;
use App\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property TipoMaterial $tipo
 * @property integer $catmat
 * @property Collection<int, MaterialUnidade> $material_unidades
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiais';

    protected $fillable = [
        'nome',
        'descricao',
        'tipo',
        'catmat'
    ];

    protected $casts = [
        'tipo' => TipoMaterial::class,
    ];

    public function material_unidades()
    {
        return $this
            ->hasMany(MaterialUnidade::class)
            ->join('unidades', 'materiais_unidades.unidade_id', 'unidades.id')
            ->orderBy('unidades.nome');
    }

    public function delete()
    {
        return DB::transaction(function () {
            $this->material_unidades()->delete();
            return parent::delete();
        });
    }
}
