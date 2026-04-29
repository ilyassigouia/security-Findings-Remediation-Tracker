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
    Schema::create('findings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->string('name');
        $table->text('description');
        $table->enum('severity', ['Critical', 'High', 'Medium', 'Low']);
        $table->enum('status', ['Open', 'In Progress', 'Fixed'])->default('Open');
        $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('findings');
    }
};
