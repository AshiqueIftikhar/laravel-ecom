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
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no');
            $table->date('date_time');

            $table->unsignedBigInteger('vendor_id');

            $table->unsignedBigInteger('warehouse_id');

            $table->unsignedBigInteger('added_by');

            $table->string('status');
            $table->integer('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
