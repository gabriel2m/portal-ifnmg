<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Categorias: int
{
    case DESENVOLVIMENTO_DE_PRODUTOS = 1;
    case PRESTACAO_DE_SERVICOS = 2;
    case EMPRESAS_JUNIOR = 3;
    case ESCRITORIO_DE_PROJETOS = 4;

    public function label(): string
    {
        return match ($this) {
            Categorias::DESENVOLVIMENTO_DE_PRODUTOS => 'Desenvolvimento de Produtos',
            Categorias::PRESTACAO_DE_SERVICOS => 'Prestação de Serviços',
            Categorias::EMPRESAS_JUNIOR => 'Empresas Júnior',
            Categorias::ESCRITORIO_DE_PROJETOS => 'Escritório de Projetos'
        };
    }

    public function descricao(): string
    {
        return match ($this) {
            Categorias::DESENVOLVIMENTO_DE_PRODUTOS => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            Categorias::PRESTACAO_DE_SERVICOS => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            Categorias::EMPRESAS_JUNIOR => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.',
            Categorias::ESCRITORIO_DE_PROJETOS => 'TODO: Descrição.
            Suscipit nobis id est quia. Laborum consequuntur aut omnis rerum veritatis aspernatur neque. Ea
            sit dolorum et dolor sed autem dolorem. Eos ullam vel rerum dolore similique. In consequuntur quo mollitia animi
            sequi deleniti. Dolor dignissimos officia rerum dolorem.'
        };
    }

    public function slug(): string
    {
        return Str::slug($this->name);
    }

    public static function valueList()
    {
        return array_column(Categorias::cases(), 'value');
    }
}
