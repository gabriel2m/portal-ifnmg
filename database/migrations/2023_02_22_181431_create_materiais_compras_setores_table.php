<?php

use App\Models\MaterialCompra;
use App\Models\MaterialCompraSetor;
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
        Schema::create(MaterialCompraSetor::tableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaterialCompra::class)->constrained(MaterialCompra::tableName())->cascadeOnDelete();
            $table->foreignIdFor(Setor::class)->constrained(Setor::tableName());
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
        Schema::dropIfExists(MaterialCompraSetor::tableName());
    }
};
