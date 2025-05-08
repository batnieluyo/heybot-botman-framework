<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'phone',
        'display_name',
        'current_group',
        'current_stage',
        'message_received_at',
        'message_send_at',
    ];
}
