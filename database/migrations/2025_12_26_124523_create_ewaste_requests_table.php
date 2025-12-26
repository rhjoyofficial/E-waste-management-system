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
        Schema::create('ewaste_requests', function (Blueprint $table) {
            $table->id();

            // User who submitted request
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Assigned collector (nullable)
            $table->foreignId('collector_id')
                ->nullable()
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreignId('category_id')->constrained()->restrictOnDelete();

            $table->string('device_condition'); // working, damaged, dead
            $table->integer('quantity')->default(1);

            $table->text('pickup_address');
            $table->date('preferred_pickup_date')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'assigned',
                'collected',
                'recycled',
                'rejected'
            ])->default('pending');

            $table->text('user_note')->nullable();
            $table->text('admin_remark')->nullable();
            $table->text('collector_remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ewaste_requests');
    }
};
