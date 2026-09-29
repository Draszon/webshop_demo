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
        Schema::table('orders', function (Blueprint $table) {
            // Átnevezés: shipping_postal_code -> shipping_zip (ha létezett)
            if (Schema::hasColumn('orders', 'shipping_postal_code')) {
                $table->renameColumn('shipping_postal_code', 'shipping_zip');
            }

            // Új számlázási mezők hozzáadása
            $table->string('billing_name')->after('customer_phone');
            $table->string('billing_tax_number')->nullable()->after('billing_name');
            $table->string('billing_zip', 10)->after('billing_tax_number');
            $table->string('billing_city')->after('billing_zip');
            $table->string('billing_address')->after('billing_city');

            // Új szállítási mezők hozzáadása
            $table->string('shipping_name')->after('billing_address');
            $table->text('shipping_comment')->nullable()->after('shipping_address');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_tax_number',
                'billing_zip',
                'billing_city',
                'billing_address',
                'shipping_name',
                'shipping_comment',
            ]);

            if (Schema::hasColumn('orders', 'shipping_zip')) {
                $table->renameColumn('shipping_zip', 'shipping_postal_code');
            }
        });
    }
};
