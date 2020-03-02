<?php

namespace App\Repository;

use App\Model\User;

class UserRepository
{

    public function createUser($name,$email,$password)
    {
        User::create(['name'=>$name,'email'=>$email,'password'=>$password]);
    }

    public static function findUserById($id)
    {
        return User::find($id);
    }

    public static function findUserByEmailAndPassword($email,$password)
    {
        return User::where('email',$email)
            ->where('password',$password)->get()[0];
    }


}
