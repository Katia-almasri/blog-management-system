<?php

namespace App\appServices;

use App\User;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Repositories\userRepository;




class userService{

    use GeneralTrait;

    public userRepository $userRepository;

    public function __construct(userRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    public function registerUser(Request $request){
        try{

            DB::beginTransaction();
                    $user = $this->userRepository->create($request);
            DB::commit();
            return  ["status"=>true, "message"=>"user added to database successfully"];

        }catch (\Exception $exception) {
            DB::rollback();
            return  ["status"=>false, "message"=>"error in adding the user"];
        }
    }

}