<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->string('parent_id')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('key')->nullable();
            $table->string('parent_key')->nullable();
            $table->string('code')->nullable();
            $table->text('value_local')->nullable();
            $table->json('value_translation')->nullable();
            $table->string('description')->nullable();
            $table->json('meta_value')->nullable();
            $table->boolean('is_active')->nullable();
            $table->unsignedBigInteger('created_by')->default(0)->index();
            $table->unsignedBigInteger('updated_by')->default(0)->index();
            $table->timestamps();
            $table->engine    = 'InnoDB';
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lookups');
    }
};
