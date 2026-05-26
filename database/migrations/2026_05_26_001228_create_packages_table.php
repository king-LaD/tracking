<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique(); // Généré automatiquement
            $table->string('client_name');
            $table->string('destination');
            $table->string('current_status')->default('En attente'); // Verrouillé par les statuts prédéfinis
            $table->dateTime('registration_date'); // Modifiable rétroactivement par l'admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};