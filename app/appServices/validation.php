<?php
 namespace App\appServices;
 use Validator;
 use Auth;
 use Illuminate\Http\Request;
 use App\Traits\GeneralTrait;

class validation {
    use GeneralTrait;

    public function checkInput(Request $request){

        $rules = [
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|min:3|max:51",
            "name" => "required|min:3|max:51|unique:users,name",

       ];
        $validator = Validator::make($request->all(),$rules);

       if ($validator->fails())  
            return (["status"=>false, 'error'=>$validator->errors(), "errNum"=>401]); 

        return (["status"=>true, "error"=>"", "message"=>"validation true",  "errNum"=>""]); 

    }

    public function checkVideoTitleValidation(Request $request){
        $rules = [
            "title" => "required|max:255"
       ];
       
        $validator = Validator::make($request->all(),$rules);

       if ($validator->fails())  
            return (["status"=>false, 'error'=>$validator->errors(), "errNum"=>401]); 

        return (["status"=>true, "error"=>"", "message"=>"validation true",  "errNum"=>""]); 
    }

    public function checkTextTitleValidation(Request $request){
        $rules = [
            "title" => "required|max:255",
            "details" => "required|max:255"
       ];
       
        $validator = Validator::make($request->all(),$rules);

       if ($validator->fails())  
            return (["status"=>false, 'error'=>$validator->errors(), "errNum"=>401]); 

        return (["status"=>true, "error"=>"", "message"=>"validation true",  "errNum"=>""]);    
    }

    public function checkValidationComment(Request $request){
        $rules = [
            "content" => "required|max:255"
       ];
       
        $validator = Validator::make($request->all(),$rules);
       if ($validator->fails())
            return (["status"=>false, 'error'=>$validator->errors(), "errNum"=>401]); 

       return (["status"=>true, "error"=>"", "message"=>"validation true",  "errNum"=>""]); 
    }

    
}
