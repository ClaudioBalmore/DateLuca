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
            $table->string('slug')->nullable()->after('name');
        });

        // Copy existing nickname values into the new slug column.
        \Illuminate\Support\Facades\DB::statement('UPDATE users SET slug = nickname');

        Schema::table('users', function (Blueprint $table) {
            $table->unique('slug');
            $table->dropColumn('nickname');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('name');
        });

        // Copy slug back into nickname.
        \Illuminate\Support\Facades\DB::statement('UPDATE users SET nickname = slug');

        Schema::table('users', function (Blueprint $table) {
            $table->unique('nickname');
            $table->dropColumn('slug');
        });
    }
};
