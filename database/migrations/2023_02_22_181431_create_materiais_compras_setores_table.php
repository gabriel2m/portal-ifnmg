<?php

use App\Models\MaterialCompra;
use App\Models\Setor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiais_compras_setores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaterialCompra::class)->constrained('materiais_compras')->cascadeOnDelete();
            $table->foreignIdFor(Setor::class)->constrained('setores');
            $table->float('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setores_materiais_compras');
    }
};
