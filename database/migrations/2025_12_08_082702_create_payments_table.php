*
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique()->nullable();
            
            // IMPORTANT: Utilisez unsignedBigInteger au lieu de foreignId()
            $table->unsignedBigInteger('user_id'); // Référence id_utilisateur
            $table->unsignedBigInteger('content_id'); // Référence id_contenu
            
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded'])->default('pending');
            $table->enum('payment_type', ['article', 'monthly', 'annual']);
            $table->enum('payment_method', ['mtn', 'moov', 'visa', 'mastercard', 'wave']);
            $table->string('phone_number')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            $table->string('currency')->default('XOF');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'content_id']);
            $table->index('status');
            $table->index('transaction_id');
            
            // Ajouter les contraintes MANUELLEMENT après
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
