<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('ussers')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');  
            $table->date('from');     
            $table->integer('until');      
            $table->float('price', 8, 2); 
            $table->float('paid', 8, 2);
            $table->integer('state');
            $table->timestamps();       
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_user');
    }
};
