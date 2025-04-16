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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->json('questions'); // Stocke le QCM au format JSON
            $table->json('languages'); // Pour garder une trace des langages choisis
            $table->string('difficulty'); // Facile, Moyen, Difficile
            $table->unsignedInteger('num_questions');
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); // Ajout de la colonne user_id
        });

        // Ajouter la clé étrangère après avoir créé la colonne user_id
        Schema::table('assessments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        
        Schema::dropIfExists('assessments');
    }
};
