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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('fund_id')->constrained('funds')->onDelete('cascade');
            $table->foreignId('transaction_type_id')->constrained('transaction_types')->onDelete('cascade');

            $table->decimal('amount', 12, 2);
            $table->string('client_name', 255);
            $table->string('contact', 20);
            $table->text('address');
            $table->string('email', 255);
            $table->string('op_number', 100);
            $table->string('payment_mode', 50)->default('Cash');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
