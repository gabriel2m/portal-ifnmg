<?php

use App\Models\Setor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setores', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        foreach ([
            'Last',
            'Paleontologia',
            'Grãos e Sementes',
            'Botânica',
            'Bromatologia',
            'Enfermagem',
            'Entomologia',
            'Fisiologia',
            'Fitopatologia',
            'Geoprocessamento',
            'Topografia',
            'Plantas Daninhas',
            'Hidráulica',
            'Iterações Biológicas',
            'Mecanização',
            'Microbiologia',
            'Citologia',
            'Animais Monogástricos',
            'Recuperação de Áreas',
            'Química',
            'Zoologia',
            'Física',
            'Construção Civil',
        ] as $nome)
            Setor::create(compact('nome'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setores');
    }
}
