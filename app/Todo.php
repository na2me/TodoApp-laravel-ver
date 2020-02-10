<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
      'name',
        'start_date',
        'end_date',
        'is_finished'
    ];

    public function createTodo($name, $endDate){

        Todo::create(["name"=>$name,"end_date"=>$endDate]);
    }
}
