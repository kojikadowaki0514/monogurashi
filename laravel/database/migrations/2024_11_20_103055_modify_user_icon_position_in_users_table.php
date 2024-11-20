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
            // user_icon カラムを削除して再追加（順序変更のため）
            $table->dropColumn('user_icon');
        });

        Schema::table('users', function (Blueprint $table) {
            // name の後に user_icon を再追加
            $table->string('user_icon')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // user_icon カラムを削除
            $table->dropColumn('user_icon');
        });

        Schema::table('users', function (Blueprint $table) {
            // email の後に user_icon を再追加（元に戻す場合）
            $table->string('user_icon')->nullable()->after('email');
        });
    }
};
