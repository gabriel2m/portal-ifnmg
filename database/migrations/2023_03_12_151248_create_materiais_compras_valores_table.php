<?php

use App\Models\MaterialCompra;
use App\Models\MaterialCompraValor;
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
        Schema::create(MaterialCompraValor::tableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaterialCompra::class)->constrained(MaterialCompra::tableName())->cascadeOnDelete();
            $table->float('valor');
            $table->timestamps();
        });

        Schema::table(MaterialCompra::tableName(), function (Blueprint $table) {
            $table->string('responsavel_valores')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(MaterialCompra::tableName(), function (Blueprint $table) {
            $table->dropColumn('responsavel_valores');
        });

        Schema::dropIfExists(MaterialCompraValor::tableName());
    }
};
