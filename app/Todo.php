<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * @var string
     */
    private static $searchedName = "";
    protected $fillable = [
      'name',
        'start_date',
        'end_date',
        'is_finished'
    ];

    public static function createTodo($name, $endDate)
    {
        Todo::create(["name"=>$name,"end_date"=>$endDate]);
    }

    public static function updateTodo($todo, $request)
    {
        $todo->update($request->all());
    }

    public static function deleteTodo($todo)
    {
        $todo->delete();
    }

    public static function findTodoById($id)
    {
        return Todo::findOrFail($id);
    }

    public static function findAllTodos()
    {
        return Todo::all();
    }

    public static function findTodosByContainsName($searchedName)
    {
        return Todo::where("name","like","%".$searchedName."%")->get();
    }


}
