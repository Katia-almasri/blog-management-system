<?php

namespace App\Repositories;

use App\Models\articleComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class commentRepository 
{
    public $articleComments;


    function __construct(articleComments $articleComments) {
	$this->articleComments = $articleComments;
    }


    public function getAll()
    {
        return $this->articleComments->getAll();
    }


    public function find($id)
    {
        return $this->articleComments->findArticleComment($id);
    }


    public function delete($id)
    {
        return $this->articleComments->deleteArticleComment($id);
    }

    public function create(Request $request, $textBlogId){
        try {
            DB::beginTransaction();
            $newComment = new articleComments();
            $newComment->user_id = auth('api')->user()->id;
            $newComment->article_id = $textBlogId;
            $newComment->content = $request->content;
            $newComment->save();
            DB::commit();
            ["status"=>true, "message"=>$newComment];
            return $newComment;

        } catch (\Throwable $th) {
            DB::rollback();
            return  ["status"=>false, "message"=>"error in adding a new comment"];
        }
       
        
    }
}