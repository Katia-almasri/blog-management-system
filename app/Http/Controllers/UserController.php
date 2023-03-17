<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\articleComments;
use App\appServices\commentService;
use App\Repositories\commentRepository;
use App\appServices\validation;

class UserController extends Controller
{

    protected commentService $commentService;
    protected validation $validation;

    public function __construct(validation $validation)
    {
        $this->commentService  = new commentService(new commentRepository(new articleComments));
        $this->validation = $validation;
    }

    public function addComment(Request $request, $textBlogId){
        try{

           $vaidatingComment = $this->validation->checkValidationComment($request);
           if($vaidatingComment['error']!=null)
                return  response()->json(["error"=>$vaidatingComment['error'], "errNum"=>$vaidatingComment['errNum']]);

           $newComment = $this->commentService->addComment($request, $textBlogId);
           if($newComment['status']==true)
                return response()->json(["status"=>true, "message"=>"your comment added successfully"]);

        }catch (\Exception $exception) {
            return response()->json(["status"=>false, "message"=>$exception->getMessage()]);
        }
        
    }
}
