<?php

use App\Models\Activity\ActivityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Participant;
use MatanYadaev\EloquentSpatial\Enums\Srid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ActivityType::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Participant::class)->index()->constrained()->cascadeOnDelete();
            $table->string('name', 50);
            $table->string('description', 800);
            $table->string('media_file');
            $table->string('short_description', 200);
            $table->string('registration_link');
            $table->geometry('area', 'polygon', Srid::WGS84->value);
            $table->json('activity_times');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
