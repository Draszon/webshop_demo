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
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('pattern'); // pl. Pilot Sport 5
            $table->string('slug')->unique();
            $table->unsignedInteger('width'); // pl. 205
            $table->unsignedInteger('profile'); // pl. 55
            $table->unsignedInteger('diameter'); // pl. 16
            $table->enum('season', ['nyári', 'téli', 'négyévszakos']);
            $table->string('speed_index')->nullable(); // pl. H, V, Y
            $table->unsignedInteger('load_index')->nullable(); // pl. 91
            $table->unsignedInteger('price'); // ár Ft-ban
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tires');
    }
};
