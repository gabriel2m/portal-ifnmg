<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum CategoriaPerfil: int
{
    use EnumTrait;

    case DesenvolvimentoProdutos = 1;
    case PrestacaoServicos = 2;
    case EmpresasJunior = 3;
    case EscritorioProjetos = 4;

    public function label(): string
    {
        return match ($this) {
            CategoriaPerfil::DesenvolvimentoProdutos => 'Desenvolvimento de Produtos',
            CategoriaPerfil::PrestacaoServicos => 'Prestação de Serviços',
            CategoriaPerfil::EmpresasJunior => 'Empresas Júnior',
            CategoriaPerfil::EscritorioProjetos => 'Escritório de Projetos'
        };
    }

    public function slug(): string
    {
        return Str::slug($this->label());
    }
}
