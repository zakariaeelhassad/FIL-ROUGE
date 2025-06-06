<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_admin_profile_id')->constrained('club_admin_profiles')->onDelete('cascade');
            $table->string('nom_titre');
            $table->integer('nombre')->default(1);
            $table->text('description_titre')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titres');
    }
}
