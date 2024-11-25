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
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('tag_name'); // category_id を追加
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade'); // 外部キー制約
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // 外部キー制約を削除
            $table->dropColumn('category_id'); // category_id カラムを削除
        });
    }
};
