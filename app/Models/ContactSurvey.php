<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSurvey extends Model
{
    protected $fillable = [
        'survey_id',
        'contact_id',
        'is_for',
        'completed_at',
    ];
}
