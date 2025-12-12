<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionOption extends Model
{
    protected  $fillable = [
        'survey_question_id',
        'message',
        'weight',
    ];
}
