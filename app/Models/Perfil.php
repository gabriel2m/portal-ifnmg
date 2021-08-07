<?php

namespace App\Models;

use Carbon\Carbon;
use ElasticScoutDriverPlus\QueryDsl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * @property int $id
 * @property string $nome
 * @property \Illuminate\Database\Eloquent\Collection $categorias
 * @property-read string $categorias_label
 * @property string $descricao
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Perfil extends Model
{
    use HasFactory, Searchable, QueryDsl;

    protected $table = 'perfis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $with = ['categorias'];

    protected $perPage = 7;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'categorias' => $this->categorias->pluck('id')
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categorias()
    {
        return $this
            ->belongsToMany(Categoria::class, 'perfis_categorias')
            ->orderBy('categoria');
    }

    public function getCategoriasLabelAttribute()
    {
        return $this->categorias->implode('categoria', ' | ');
    }
}
