<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKeyValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_value', function (Blueprint $table) {
            $table->increments('kv_id');
            $table->string('kv_key', 100);
            $table->text('kv_value');
            $table->text('kv_memo')->default('');
            $table->enum('kv_status', ['active', 'inactive'])->default('inactive');
            $table->tinyInteger('kv_deleted')->default(0);
            $table->unsignedInteger('kv_created_user_id');
            $table->string('kv_created_user', 255);
            $table->unsignedInteger('kv_updated_user_id');
            $table->string('kv_updated_user', 255);
            $table->unsignedInteger('kv_deleted_user_id')->default(0);
            $table->string('kv_deleted_user', 255)->default('');
            $table->dateTime('kv_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('kv_deleted_at')->default('1000-01-01 00:00:00');
            $table->timestamp('kv_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->index('kv_key', 'idx_kv_key');
            $table->engine = 'INNODB';
            $table->charset = 'UTF8MB4';
            $table->collation = 'UTF8MB4_UNICODE_CI';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('key_value');
    }
}
