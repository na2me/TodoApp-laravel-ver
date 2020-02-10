<?php


namespace App;


class TodoService
{

    /**
     * TodoService constructor.
     */
    public function __construct()
    {
    }

    public function parseAttributes($request)
    {
        return $request->all();
    }

    public function parseSearchedName($request)
    {
        return $request->input("name");
    }
}
