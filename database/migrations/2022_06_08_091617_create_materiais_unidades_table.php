<?php

use App\Models\Material;
use App\Models\MaterialUnidade;
use App\Models\Unidade;
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
        Schema::create(MaterialUnidade::tableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Material::class)->constrained(Material::tableName());
            $table->foreignIdFor(Unidade::class)->constrained();
            $table->softDeletes();
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
        Schema::dropIfExists(MaterialUnidade::tableName());
    }
};
