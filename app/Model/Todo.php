<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * @var string
     */
    protected $fillable = [
      'name',
        'start_date',
        'end_date',
        'is_finished',
        'user_id',
    ];

}
