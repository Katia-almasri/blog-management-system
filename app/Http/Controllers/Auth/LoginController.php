<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\userRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\appServices\validation;
use App\appServices\userService;
use App\Traits\GeneralTrait;
use App\Models\User;
use Validator;

class LoginController extends Controller
{
   
    use AuthenticatesUsers, GeneralTrait;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected validation $validation;
    protected $userService;

    public function __construct(validation $validation)
    {
        $this->middleware('guest')->except('logout');
        $this->validation = $validation;
        $this->userService = new userService(new userRepository(new User));
    }


    public function login(Request $request){ 

        $rules = [
            "email" => "required",
            "password" => "required"

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($validator, $code);
        }

        $credentials = $request->only(['email', 'password']);
        $token = Auth::attempt($credentials);
        if(!$token){ 
            return $this->returnError('E001', 'error in inputs');
           
        } 
        else{ 
            $userInfo = Auth::user(); 
            $user = $userInfo;
            $user->token =  $userInfo->createToken('auth-token')->accessToken; 
            return $this->returnData('user', $user);
        } 
    }

//     public function register(Request $request) 
//     { 
//         $validator = Validator::make($request->all(), [ 
//             'name' => 'required',
//             'email' => 'required|email|unique:users',
//             'password' => 'required',
//         ]);
//         if ($validator->fails()) { 
//              return response()->json(['error'=>$validator->errors()], 401);            
//  }
//  $input = $request->all(); 
//         $input['password'] = Hash::make($input['password']); 
//         $user = User::create($input); 
//         $success['token'] =  $user->createToken('MyLaravelApp')-> accessToken; 
//         $success['name'] =  $user->name;
//  return response()->json(['success'=>$success], 200); 
//     }

    public function register(Request $request){
        try{
            $validator =$this->validation->checkInput($request);
            if($validator['error']!=null)
                return  response()->json(["error"=>$validator['error'], "errNum"=>$validator['errNum']]);

            //register the user into the DB
            $registerUserInDB = $this->userService->registerUser($request);
            if($registerUserInDB['status']==false)
                throw new Exception($registerUserInDB['message']);
            return $this->login($request); 

        }catch(\Exception $exception){
            return  response()->json(["status"=>false, "message"=>$exception->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
         $request->user()->token()->revoke();
         return response()->json([
           'message' => 'Successfully logged out'
         ]);
 }
}
