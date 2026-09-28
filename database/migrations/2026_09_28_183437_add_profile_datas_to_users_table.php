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
        Schema::table('users', function (Blueprint $table) {
            // 1. A régi, általános mezők törlése egy tömbben
            $table->dropColumn(['phone', 'address', 'city', 'postal_code']);
    
            // 2. Az új, elkülönített profil mezők hozzáadása
            $table->string('phone')->nullable();
            
            $table->string('billing_name')->nullable();
            $table->string('billing_tax_number')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_address')->nullable();
    
            $table->string('shipping_name')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_address')->nullable();
            $table->text('shipping_comment')->nullable();
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Visszagörgetésnél töröljük az újakat
            $table->dropColumn([
                'phone',
                'billing_name', 'billing_tax_number', 'billing_zip', 'billing_city', 'billing_address',
                'shipping_name', 'shipping_zip', 'shipping_city', 'shipping_address', 'shipping_comment'
            ]);
    
            // És visszatesszük a régieket
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
        });
    }
};
