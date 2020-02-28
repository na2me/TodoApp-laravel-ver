<?php


namespace App;


use Illuminate\Support\Facades\Auth;

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

    public function loginUser($email,$password)
    {
        $user = User::where('email',$email)
            ->where('password',$password)->get()[0];
        Auth::login($user);
    }
}
