<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $material_compra_id
 * @property MaterialCompra $material_compra
 * @property integer $setor_id
 * @property Setor $setor
 * @property integer $quantidade
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaterialCompraSetor extends Model
{
    use HasFactory;

    protected $table = 'materiais_compras_setores';

    protected $guarded = [];

    public function material_compra()
    {
        return $this->belongsTo(MaterialCompra::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class)->withTrashed();
    }
}
