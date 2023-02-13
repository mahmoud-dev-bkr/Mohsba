<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        "title_ar", "title_en", "message_ar", "message_en", "user_id", "icon", "sent", "seen"
    ];
}
