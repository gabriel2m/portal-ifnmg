<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $guarded = [];

    public function perfis()
    {
        return $this
            ->belongsToMany(Perfil::class, 'perfis_categorias')
            ->orderBy('nome');
    }

    /**
     * Retorna a lista de categorias em ordem alfabetica.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeList($query)
    {
        return $query->orderBy('categoria')->get();
    }
}
