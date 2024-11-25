<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_type',
        'schedule_date',
        'feed_time',
        'status',
    ];
}
