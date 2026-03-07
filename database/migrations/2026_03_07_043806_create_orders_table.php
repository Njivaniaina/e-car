<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nom_client');
            $table->string('telephone');
            $table->text('adresse');
            $table->string('email')->nullable();
            $table->bigInteger('total_ariary');
            $table->enum('statut', ['en_attente', 'confirme', 'en_cours', 'livre', 'annule'])->default('en_attente');
            $table->text('notes')->nullable();
            $table->string('reference')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
