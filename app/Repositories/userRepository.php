<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userRepository 
{
    public $user;


    function __construct(User $user) {
	$this->user = $user;
    }


    public function getAll()
    {
        return $this->user->getAll();
    }


    public function find($id)
    {
        return $this->user->findUser($id);
    }


    public function delete($id)
    {
        return $this->user->deleteUser($id);
    }

    public function create(Request $request){
        
        $user = new User();
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save(); 

        return $user;
    }
}