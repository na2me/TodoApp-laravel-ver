<?php


namespace App\Repository;


use App\Todo;

class TodoRepository
{
    public static function createTodo($name, $endDate, $userId)
    {
        Todo::create(["name"=>$name,"end_date"=>$endDate,'user_id'=>$userId]);
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

    public static function findTodosByContainsName($searchedName)
    {
        return Todo::where("name","like","%".$searchedName."%")->get();
    }

    public static function saveTodo($todo)
    {
        $todo->save();
    }
}
