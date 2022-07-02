<?php

use App\Models\Unidade;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        foreach ([
            'Unidade',
            'Litro',
            'Metro',
            'Metro³',
            'Saco 1kg',
            'Saco 20kg',
            'Saco 50kg',
            'Balde 18L',
            'Lata 18L',
            'Barra 12M',
            'Caixa',
            'Pacote',
            'Conjunto',
        ] as $nome)
            Unidade::create(compact('nome'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidades');
    }
}
