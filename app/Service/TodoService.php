<?php


namespace App\Service;


use App\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;

class TodoService
{

    /**
     * TodoService constructor.
     */
    public function __construct()
    {
    }

    public function parseSearchedName($request)
    {
        return $request->input("name");
    }

    public function loginUser($email,$password)
    {
        $user = (new UserRepository)->findUserByEmailAndPassword($email,$password);
        Auth::login($user);
    }

    public function toggleStatus($is_finished)
    {
        if ($is_finished == 0){
            return 1;
        } else {
            return 0;
        }
    }
}
