<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('gambar_menu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
};
