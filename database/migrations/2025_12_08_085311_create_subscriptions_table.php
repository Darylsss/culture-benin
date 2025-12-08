
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            
            $table->enum('type', ['monthly', 'annual']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            
            // MODIFICATION ICI : Utiliser datetime au lieu de timestamp
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('cancelled_at')->nullable();
            
            $table->json('features')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id', 'status']);
            $table->index('end_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
