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
 * @property int $categoria
 * @property-read string $categoria_label
 * @property string $descricao
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Perfil extends Model
{
    use HasFactory, Searchable, QueryDsl;

    const CATEGORIA_EMPRESAS_JUNIOR = 1;
    const CATEGORIA_INCUBADORA_TECNOLOGICA = 2;
    const CATEGORIA_INSTITUICOES_PARCEIRAS = 3;
    const CATEGORIA_LABORATORIOS = 4;
    const CATEGORIA_PESQUISADORES = 5;

    const LABELS_CATEGORIAS = [
        SELF::CATEGORIA_PESQUISADORES => 'Pesquisadores',
        SELF::CATEGORIA_LABORATORIOS => 'Laboratórios',
        SELF::CATEGORIA_EMPRESAS_JUNIOR => 'Empresas Júnior',
        SELF::CATEGORIA_INCUBADORA_TECNOLOGICA => 'Incubadora Tecnológica',
        SELF::CATEGORIA_INSTITUICOES_PARCEIRAS => 'Instituições Parceiras',
    ];

    protected $table = 'perfis';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    const PER_PAGE = 7;

    protected $perPage = SELF::PER_PAGE;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'nome' => $this->nome,
            'categoria' => $this->categoria,
            'descricao' => $this->descricao,
        ];
    }

    public function getCategoriaLabelAttribute()
    {
        return $this::LABELS_CATEGORIAS[$this->categoria];
    }

    public static function categorias()
    {
        return array_keys(SELF::LABELS_CATEGORIAS);
    }
}
