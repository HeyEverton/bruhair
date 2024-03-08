<?php

use App\Enums\PaymentType;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->decimal('total', 12, 2);
            $table->text('description')->nullable();
            $table->enum('payment_type', [
                PaymentType::CREDIT->value,
                PaymentType::DEBIT->value,
                PaymentType::PIX->value,
                PaymentType::CASH->value,
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
