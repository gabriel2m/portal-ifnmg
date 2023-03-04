<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $material_compra_id
 * @property integer $setor_id
 * @property Setor $setor
 * @property integer $quantidade
 * @property integer $unidade_id
 * @property Unidade $unidade
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaterialCompraSetor extends Model
{
    use HasFactory;

    protected $table = 'materiais_compras_setores';

    protected $guarded = [];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class)->withTrashed();
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class)->withTrashed();
    }
}
