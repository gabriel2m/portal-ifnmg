<?php

use App\Models\Material;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Material::tableName(), function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao');
            $table->integer('catmat')->unique();
            $table->tinyInteger('tipo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Material::tableName());
    }
}
