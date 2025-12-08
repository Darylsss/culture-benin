<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Contraintes pour la table payments
        Schema::table('payments', function (Blueprint $table) {
            // ✅ Pointer vers users (clients) et non utilisateurs (backend)
            $table->foreign('user_id')
                  ->references('id')           // ← id au lieu de id_utilisateur
                  ->on('users')                // ← users au lieu de utilisateurs
                  ->onDelete('cascade');
            
            $table->foreign('content_id')
                  ->references('id_contenu')
                  ->on('contenus')
                  ->onDelete('cascade');
        });
        
        // Contraintes pour la table subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            // ✅ Pointer vers users (clients)
            $table->foreign('user_id')
                  ->references('id')           // ← id au lieu de id_utilisateur
                  ->on('users')                // ← users au lieu de utilisateurs
                  ->onDelete('cascade');
            
            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);
        });
        
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['content_id']);
        });
    }
};