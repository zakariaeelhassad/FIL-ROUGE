
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained('club_admin_profiles')->onDelete('cascade');
            $table->foreignId('joueur_id')->constrained('joueur_profiles')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->unique(['club_id', 'joueur_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('invitations');
    }
};