<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->nullable()->constrained()->onDelete('cascade');
            $table->dateTime('appointment_date');   
            $table->enum('status', ['Pendiente', 'En proceso', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->text('observations')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Usaremos este campo para el precio final
            $table->enum('payment_method', ['Efectivo', 'Nequi', 'Daviplata', 'Tarjeta', 'Llave_nequi', 'Llave_daviplata'])->nullable();
            $table->string('photo')->nullable(); // Foto final del servicio
            
            // Nuevos campos
            $table->timestamp('checkin_time')->nullable();
            $table->string('checkin_photo')->nullable();
            $table->text('checkin_observations')->nullable();
            
            $table->string('process_photo')->nullable(); // Foto durante el proceso
            $table->text('process_observations')->nullable(); // Observaciones durante el proceso
            
            $table->timestamp('checkout_time')->nullable();
            $table->string('checkout_photo')->nullable(); // Foto de salida
            $table->text('checkout_observations')->nullable();

            // Cita temporal
            $table->string('pet_name_temp')->nullable();
            $table->string('owner_name_temp')->nullable();
            $table->enum('gender_temp', ['Macho', 'Hembra'])->nullable();
            $table->string('phone_temp')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};