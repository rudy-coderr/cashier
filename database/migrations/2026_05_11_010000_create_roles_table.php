<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // Seed default roles
        DB::table('roles')->insert([
            ['name' => 'reviewer', 'label' => 'Reviewer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'label' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'accountant', 'label' => 'Accountant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'maker', 'label' => 'Maker', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Add relation to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('roles');
    }
};
