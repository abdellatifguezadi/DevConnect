<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->integer('likes_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Ajouter la contrainte de clé étrangère après la création de la table
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('comments')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}; 