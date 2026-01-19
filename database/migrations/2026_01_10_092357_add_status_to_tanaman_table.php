<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTanamanTable extends Migration
{
    public function up()
    {
        Schema::table('tanaman', function (Blueprint $table) {
            $table->enum('status', ['sehat', 'perhatian', 'sakit'])
                  ->default('sehat');
        });
    }

    public function down()
    {
        Schema::table('tanaman', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
