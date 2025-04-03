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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('number');
            $table->string('buyer_tin');
            $table->string('seller_tin');
            $table->string('product_code', 3);
            $table->decimal('net_amount', 12, 2);
            $table->date('issue_date');
            $table->date('edit_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
