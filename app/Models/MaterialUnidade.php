<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property integer $material_id
 * @property Material $material
 * @property integer $unidade_id
 * @property Unidade $unidade
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaterialUnidade extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiais_unidades';

    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class)->withTrashed();
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class)->withTrashed();
    }
}
