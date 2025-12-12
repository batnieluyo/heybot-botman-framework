<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAffirmation extends Model
{
    protected $fillable = [
        'survey_question_id',
        'survey_question_option_id',
        'message',
    ];
}
