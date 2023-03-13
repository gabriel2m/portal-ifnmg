<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $material_compra_id
 * @property MaterialCompra $material_compra
 * @property float $valor
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaterialCompraValor extends Model
{
    use HasFactory;
    use TableName;

    protected $table = 'materiais_compras_valores';

    protected static $unguarded = true;

    public function material_compra()
    {
        return $this->belongsTo(MaterialCompra::class);
    }
}
