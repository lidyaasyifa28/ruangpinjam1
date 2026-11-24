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
        // 1. Tabel Barang / Inventaris
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->integer('stock_total');
            $table->integer('stock_available');
            $table->timestamps();
        });

        // 2. Tabel Peminjaman
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('student_name');
            $table->string('student_class');
            $table->string('organization');
            $table->string('whatsapp');
            $table->integer('quantity');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->text('purpose');
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
        Schema::dropIfExists('items');
    }
};
