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
        ];
    }
}
