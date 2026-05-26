<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('package_title')->nullable()->after('tracking_number'); // Ex: Conteneur 40 pieds / Toyota Corolla
            $table->string('client_phone')->nullable()->after('client_name');
            $table->string('client_cni')->nullable()->after('client_phone');
            $table->date('estimated_arrival_date')->nullable()->after('registration_date');
        });

        Schema::table('package_events', function (Blueprint $table) {
            $table->string('event_title')->nullable()->after('status_description'); // Ex: "Arrivée au port de Douala"
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['package_title', 'client_phone', 'client_cni', 'estimated_arrival_date']);
        });

        Schema::table('package_events', function (Blueprint $table) {
            $table->dropColumn('event_title');
        });
    }
};