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
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->string('status')->nullable()->comment('1=Active, 0=Deactive');
            $table->string('nationality')->nullable();
            $table->text('remarks')->nullable();
            $table->text('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('profession');
            $table->dropColumn('status');
            $table->dropColumn('nationality');
            $table->dropColumn('remarks');
            $table->dropColumn('image');
        });
    }
};
