<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_team_id')->index()->constrained('teams');
            $table->foreignId('away_team_id')->index()->constrained('teams');
            $table->tinyInteger('number_of_week')->default(0);
            $table->unsignedTinyInteger('home_team_goals')->default(0);
            $table->unsignedTinyInteger('away_team_goals')->default(0);
            $table->boolean('is_played')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixtures');
    }
};
