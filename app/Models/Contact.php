<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function move(string $toGroup, string $toStage)
    {
        $this->update([
            'current_group' => $toGroup,
            'current_stage' => $toStage,
            'message_send_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
