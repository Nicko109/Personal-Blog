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
        Schema::create('note_comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
            $table->foreignId('note_id')->index()->constrained('notes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_comments');
    }
};
