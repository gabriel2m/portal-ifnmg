<?php

namespace App\Models;

use App\Models\Traits\TableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property integer $compra_id
 * @property Compra $compra
 * @property integer $material_unidade_id
 * @property MaterialUnidade $material_unidade
 * @property MaterialCompraSetor[]|HasMany $material_compra_setores
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MaterialCompra extends Model
{
    use HasFactory;
    use TableName;

    protected $table = 'materiais_compras';

    protected $fillable = [
        'compra_id',
        'material_unidade_id',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function material_unidade()
    {
        return $this->belongsTo(MaterialUnidade::class)->withTrashed();
    }

    public function material_compra_setores()
    {
        return $this
            ->hasMany(MaterialCompraSetor::class)
            ->join(Setor::tableName(),  MaterialCompraSetor::columnName('setor_id'), Setor::columnName('id'))
            ->orderBy(Setor::columnName('nome'));
    }
}
