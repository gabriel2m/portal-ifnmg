<?php

use App\Models\Compra;
use App\Models\Material;
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
        Schema::create('materiais_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class)->constrained('materiais');
            $table->foreignIdFor(Compra::class)->constrained()->cascadeOnDelete();
            $table->float('valor');
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
        Schema::dropIfExists('materiais_compras');
    }
};
