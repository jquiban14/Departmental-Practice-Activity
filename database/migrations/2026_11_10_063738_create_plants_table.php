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
        Schema::create('plants', function (Blueprint $table) {

            $table->id();

            // Connect each plant to its creator.
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Plant information.
            $table->string('plant_name');
            $table->string('category');
            $table->decimal('unit_price', 10, 2);
            $table->text('description');

            // Track whether the plant is available.
            $table->string('stock_status', 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
