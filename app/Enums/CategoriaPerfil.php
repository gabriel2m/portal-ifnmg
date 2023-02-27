<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum CategoriaPerfil: int
{
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

    public function descricao(): string
    {
        return match ($this) {
            CategoriaPerfil::DesenvolvimentoProdutos => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            CategoriaPerfil::PrestacaoServicos => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            CategoriaPerfil::EmpresasJunior => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            CategoriaPerfil::EscritorioProjetos => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.'
        };
    }

    public function slug(): string
    {
        return Str::slug($this->name);
    }

    public static function values()
    {
        return array_column(CategoriaPerfil::cases(), 'value');
    }
}
