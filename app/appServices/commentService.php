<?php

namespace App\appServices;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Repositories\commentRepository;




class commentService{

    use GeneralTrait;

    public commentRepository $commentRepository;

    public function __construct(commentRepository $commentRepository){
        $this->commentRepository = $commentRepository;
    }

    public function addComment($comment, $textBlogId){
        try {

            $newComment = $this->commentRepository->create($comment, $textBlogId);
            if($newComment['status']==false)
                return  ["status"=>true, "message"=>$newComment];

            throw new \ErrorException($newComment['message']);

        } catch (\Exception $exception) {
            return  ["status"=>false, "message"=>$exception->getMessage()];
        }
       
    }
    

}