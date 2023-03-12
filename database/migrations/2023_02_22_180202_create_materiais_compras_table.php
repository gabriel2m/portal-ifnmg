<?php

use App\Models\Compra;
use App\Models\MaterialCompra;
use App\Models\MaterialUnidade;
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
        Schema::create(MaterialCompra::tableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MaterialUnidade::class)->constrained(MaterialUnidade::tableName());
            $table->foreignIdFor(Compra::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists(MaterialCompra::tableName());
    }
};
