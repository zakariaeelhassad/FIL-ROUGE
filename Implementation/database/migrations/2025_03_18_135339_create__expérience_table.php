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
        Schema::create('expérience', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joueur_profiles_id')->constrained('joueur_profiles')->onDelete('cascade');
            $table->string('nameClub');
            $table->string('image')->nullable(); 
            $table->date('joiningDate');
            $table->date('exitDate')->nullable();
            $table->string('place');
            $table->enum('categoryType', ['sinyor', 'jinyor', 'kadiy', 'minim']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
