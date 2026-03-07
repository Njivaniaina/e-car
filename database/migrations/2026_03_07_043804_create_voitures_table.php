<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voitures', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->bigInteger('prix_ariary');
            $table->integer('annee');
            $table->integer('kilometrage')->default(0);
            $table->enum('etat', ['neuf', 'occasion'])->default('occasion');
            $table->string('couleur')->nullable();
            $table->enum('carburant', ['essence', 'diesel', 'electrique', 'hybride'])->default('essence');
            $table->enum('transmission', ['manuelle', 'automatique'])->default('manuelle');
            $table->integer('places')->default(5);
            $table->integer('puissance_cv')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('marque_id')->constrained('marques')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('voitures');
    }
};
