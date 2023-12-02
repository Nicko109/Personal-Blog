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
        Schema::create('liked_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('note_id')->index()->constrained('notes')->onDelete('cascade');

            $table->unique(['user_id', 'note_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liked_notes');
    }
};
