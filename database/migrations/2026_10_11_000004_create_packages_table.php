<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_id', 50)->unique();
            $table->string('package_name');
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->text('invoice_message')->nullable();
            $table->string('sender');
            $table->string('phone', 50);
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('email')->index();
            $table->string('address', 500);
            $table->string('location');
            $table->string('address_type', 100);
            $table->string('image', 500)->nullable();
            $table->enum('status', ['processing', 'in_transit', 'delivered', 'cancelled'])
                ->default('processing')->index();
            $table->enum('payment_status', ['unpaid', 'paid'])
                ->default('unpaid')->index();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
