<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dbDriver = DB::getDriverName();

        if ($dbDriver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($dbDriver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        DB::table('products')->truncate();
        DB::table('users')->truncate();
        DB::table('chats')->truncate();
        DB::table('messages')->truncate();

        if ($dbDriver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($dbDriver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }
        
        Schema::table('products', function (Blueprint $table) {
            $table->integer('erf_size')->change();
            $table->integer('floor_size')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('erf_size')->change();
            $table->string('floor_size')->change();
        });
    }
};
