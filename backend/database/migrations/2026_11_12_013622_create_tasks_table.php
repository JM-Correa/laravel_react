<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    if (Schema::hasTable('tasks')) {
        return;
    }

    Schema::create('tasks', function (Blueprint $table) {
        $table->increments('idtask');
        $table->string('nombre', 45);
        $table->text('detalle');
        $table->tinyInteger('estatus')->default(0);
    });
}

public function down(): void
{
    Schema::dropIfExists('tasks');
}
};
