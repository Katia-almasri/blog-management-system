<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\addNewTextBlog;
use App\appServices\validation;
use Auth;
use Event;
use App\Models\textBlogs;

class TextBlogController extends Controller
{
    public function __construct(validation $validation)
    {
        $this->validation = $validation;
    }
    public function getTextBlogs(Request $request){
        
        $textBlogs = TextBlogs::get();
        return response()->json($textBlogs);
    }

    public function readTextBlog(Request $request, $textBlogId){

        $textBlog = TextBlogs::find($textBlogId);
        return response()->json($textBlog);
    }

    public function editTextBlog(Request $request, $textBlogId){
        $validator = $this->validation->checkTextTitleValidation($request);
        if($validator['error']!=null)
             return  response()->json(["error"=>$validator['error'], "errNum"=>$validator['errNum']]);
        $textBlog = TextBlogs::find($textBlogId);
        $textBlog->title = $request->title;
        $textBlog->details = $request->details;
        $textBlog->save();
        return response()->json(["status"=>true, "message"=>"article is updated successfully"]);
    }

    public function deleteTextBlog(Request $request, $textBlogId){

        $textBlog = TextBlogs::where('id', '=', $textBlogId)->delete();
        return response()->json(["status"=>true, "message"=>"text blog deleted successfully"]);
    }

    public function addTextBlog(Request $request){
        
        $newBlog = new TextBlogs();
        $newBlog->title = $request->title;
        $newBlog->details = $request->details;
        $newBlog->user_id = auth('api')->user()->id;
        $newBlog->save();

        event(new addNewTextBlog());
        return response()->json(["status"=>true, "message"=>"article is added successfully"]);
    }



    
}
