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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // product_id
            $table->string('name'); // e.g., Roses
            $table->text('description')->nullable();
            $table->integer('stock')->default(0);
            $table->string('image')->nullable(); // store image path
            $table->foreignId('employee_id')
                ->constrained('employees') // links to employees.id
                ->onDelete('cascade'); // if employee is deleted, products go too
            // $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
