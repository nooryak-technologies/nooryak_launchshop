<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ContactMessage extends Model
{
    public $table = "user_contact_messages";

    protected $fillable = [
        'fullname',
        'email',
        'subject',
        'message',
        'user_id'
    ];

    public static function ensureTableExists()
    {
        if (!Schema::hasTable('user_contact_messages')) {
            Schema::create('user_contact_messages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('fullname')->nullable();
                $table->string('email')->nullable();
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
            });
        }
    }
}
