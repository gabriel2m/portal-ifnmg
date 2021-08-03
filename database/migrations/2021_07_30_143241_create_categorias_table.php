<?php

use App\Models\Categoria;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('categoria')->unique();
            $table->timestamps();
        });
        foreach ([
            'Prestação de Serviços',
            'Empresa Júnior',
            'Incubadora Tecnológica',
            'Instituição Parceira',
            'Laboratório',
            'Pesquisa',
        ] as $categoria)
            Categoria::create(compact('categoria'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
