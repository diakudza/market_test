<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->integer('imageable_id')->nullable(false);
            $table->string('imageable_type')->nullable(false);
            $table->string('filename')->nullable(false);
            $table->string('path')->nullable(false);
            $table->boolean('from_url')->default(false);
            $table->string('disk')->nullable(true)->default('public');
            $table->string('alt')->nullable(true);;
            $table->string('title')->nullable(true);;
            $table->string('scope')->nullable(true);;
            $table->timestamps();
            $table->index('scope');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
};
