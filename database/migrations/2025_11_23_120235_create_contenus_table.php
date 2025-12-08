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
        Schema::create('contenus', function (Blueprint $table) {
            $table->id('id_contenu');
            $table->string('titre');
            $table->text('texte');
            $table->date('date_creation');
            $table->string('statut');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->date('date_validation')->nullable();

            $table->unsignedBigInteger('id_region');
            $table->unsignedBigInteger('id_langue');
            $table->unsignedBigInteger('id_moderateur')->nullable();
            $table->unsignedBigInteger('id_type_contenu');
            $table->unsignedBigInteger('id_auteur');
            $table->timestamps();

            $table->foreign('parent_id')->references('id_contenu')->on('contenus')->nullOnDelete();
            $table->foreign('id_region')->references('id_region')->on('regions')->cascadeOnDelete();
            $table->foreign('id_langue')->references('id_langue')->on('langues')->cascadeOnDelete();
            $table->foreign('id_moderateur')->references('id_utilisateur')->on('utilisateurs')->nullOnDelete();
            $table->foreign('id_type_contenu')->references('id_type_contenu')->on('type_contenus')->cascadeOnDelete();
            $table->foreign('id_auteur')->references('id_utilisateur')->on('utilisateurs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};
