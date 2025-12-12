<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSurveyAnswer extends Model
{
    protected $fillable = [
        'survey_id',
        'survey_question_id',
        'survey_question_option_id',
    ];
}
