<?php

namespace App\Models;

use App\Enums\Categorias;
use Carbon\Carbon;
use ElasticScoutDriverPlus\QueryDsl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $nome
 * @property string $imagem
 * @property-read string $imagem_url
 * @property int $categoria
 * @property string $descricao
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Perfil extends Model
{
    use HasFactory, Searchable, QueryDsl;

    protected $casts = [
        'categoria' => Categorias::class,
    ];

    public const TABLE = 'perfis';

    protected $table = SELF::TABLE;

    public const PER_PAGE = 3;

    protected $perPage = SELF::PER_PAGE;

    protected static $unguarded = true;

    public function toSearchableArray(): array
    {
        return [
            'nome' => $this->nome,
            'categoria' => $this->categoria,
            'descricao' => $this->descricao,
        ];
    }


    public function getImagemUrlAttribute()
    {
        return isset($this->imagem) && Storage::disk(config('app.perfil.imagem.disk'))->exists($this->imagem)
            ? Storage::disk(config('app.perfil.imagem.disk'))->{'url'}($this->imagem)
            : config('app.perfil.imagem.default_url');
    }
}
