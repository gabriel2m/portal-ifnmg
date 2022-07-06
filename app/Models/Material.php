<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property integer $catmat
 * @property integer $unidade_id
 * @property Unidade $unidade
 * @property string $unidade_label
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiais';

    protected $guarded = [];

    protected $with = ['unidade'];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class)->withTrashed();
    }

    public function getUnidadeLabelAttribute()
    {
        return $this->unidade->nome;
    }
}
