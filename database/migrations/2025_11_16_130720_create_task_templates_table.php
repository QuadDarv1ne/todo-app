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
        Schema::create('task_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // имя шаблона
            $table->string('title'); // заголовок задачи по умолчанию
            $table->text('description')->nullable();
            $table->string('priority')->default('medium'); // low|medium|high
            $table->boolean('reminders_enabled')->default(true);
            $table->integer('default_due_days')->nullable(); // смещение даты в днях (например, +3 дня)
            $table->timestamps();

            $table->index(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_templates');
    }
};
