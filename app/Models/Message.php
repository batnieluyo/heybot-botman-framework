<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    protected $primaryKey = 'ulid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'ulid',
        'direction',
        'payload_type',
        'contact_id',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
