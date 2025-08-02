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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sender_id');
            $table->unsignedInteger('receiver_id');
            $table->enum('sender_type',['company','user']);
            $table->enum('receiver_type',['company','user']);
            $table->text('message');
            $table->timestamps();
        });
    }
    //php artisan make:event ChatMessageSent
    //class ChatMessageSent implements ShouldBroadcast

//  broadcast(new ChatMessageSent($chat));

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
