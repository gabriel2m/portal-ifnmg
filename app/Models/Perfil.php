<?php

namespace App\Models;

use App\Enums\Categorias;
use App\Facades\DB;
use Carbon\Carbon;
use ElasticScoutDriverPlus\QueryDsl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

/**
 * @property int $id
 * @property string $nome
 * @property UploadedFile|string $imagem
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
        return isset($this->imagem) && $this->imagemDisk()->exists($this->imagem)
            ? $this->imagemDisk()->{'url'}($this->imagem)
            : config('app.perfil.imagem.default_url');
    }

    public static function imagemDisk()
    {
        static $disk;
        return $disk ??= Storage::disk(config('app.perfil.imagem.disk'));
    }

    public function save(array $options = [])
    {
        $originalImagem = $this->getOriginal('imagem');
        $saveImagem = is_a($this->imagem, UploadedFile::class);
        if (
            $saveImagem
            && !$this->imagem = $this->imagem->storePublicly(
                config('app.perfil.imagem.dir'),
                config('app.perfil.imagem.disk')
            )
        )
            throw new RuntimeException("Não foi possível salvar Perfil->imagem");
        $saved = false;
        try {
            $saved = parent::save($options);
            if ($saved && !$this->deleteImagem($originalImagem))
                throw new RuntimeException("Não foi possível deletar Perfil->imagem \"$originalImagem\"");
        } finally {
            if ($saveImagem && !$saved)
                $this->deleteImagem($this->imagem);
        }
        return $saved;
    }

    public function delete()
    {
        return DB::onTrueTransaction(function () {
            return parent::delete() && $this->deleteImagem($this->imagem);
        });
    }

    public static function deleteImagem($path)
    {
        return empty($path)
            || !static::imagemDisk()->exists($path)
            || static::imagemDisk()->delete($path);
    }
}
