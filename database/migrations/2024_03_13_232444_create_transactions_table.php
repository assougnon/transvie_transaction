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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->integer('montant');
            $table->integer('delai')->nullable();
            $table->string('type');
          $table->string('statut')->default('Encours')->nullable();
          $table->string('adherant_prenom')->nullable();
          $table->string('adherant_nom')->nullable();
          $table->string('adherant_entreprise')->nullable();
          $table->string('adherant_telephone')->nullable();
          $table->string('adherant_adresse')->nullable();
          $table->string('adherant_population')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('remise_id')->nullable();
            $table->foreignId('adherant_id')->nullable();
            $table->foreignId('banque_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
