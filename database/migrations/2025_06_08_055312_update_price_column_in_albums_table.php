<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0.00)->change();
        });
    }

    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            // Revert changes if necessary
            // $table->decimal('price', 10, 2)->nullable()->change(); 
        });
    }
};