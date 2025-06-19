<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lightit\Backoffice\Airline\Domain\Models\Airline;
use Lightit\Backoffice\City\Domain\Models\City;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('airline_city', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Airline::class, 'airline_id')
                ->constrained('airlines')
                ->onDelete('cascade');
            $table->foreignIdFor(City::class, 'city_id')
                ->constrained('cities')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airline_city');
    }
};
