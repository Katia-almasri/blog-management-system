<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Exception;
use App\Models\videoBlogs;
use App\appServices\validation;
use App\appServices\videoService;

class VideoBlogController extends Controller
{
    protected validation $validation;
    protected videoService $videoService;

    public function __construct(validation $validation)
    {
        $this->validation = $validation;
        $this->videoService  = new videoService();
    }

    public function getVideoBlogs (Request $request){
        $videoBlogs = videoBlogs::get();
        return response()->json($videoBlogs);
    }

    public function displayVideoBlog(Request $request, $videoBlogId){
        $videoBlog = videoBlogs::find($videoBlogId);
        //with video path
        return response()->json($videoBlog);
    }

    public function addVideoBlog(Request $request){
        try{
            $validator = $this->validation->checkVideoTitleValidation($request);
            if($validator['error']!=null)
                return  response()->json(["error"=>$validator['error'], "errNum"=>$validator['errNum']]);
            
            //first add the video to the local file system
            $uploadedVideo = $this->videoService->uploadVideoToFileSystem($request->video);
            if($uploadedVideo['status']==false)
                return response()->json(["status"=>false, "message"=>$exception->getMessage()]);
            
            //second add the title and video path to the DB
            $addedVideo = $this->videoService->addVideoToDB($request['title'],
                                                            $uploadedVideo['fileName'],
                                                            $uploadedVideo['filePath'],
                                                            auth('api')->user()->id);
                
            return response()->json(["status"=>true, "message"=>"video uploaded successfully"]);
     
        }catch(\Exception $exception){
            return response()->json(["status"=>false, "message"=>$exception->getMessage()]);
        }
        

    }

    public function editVideoBlog(Request $request, $videoBlogId){
        //1. edit the title
        try{

            $validator =$this->validation->checkVideoTitleValidation($request);
            if($validator['error']!=null)
               return  response()->json(["error"=>$validator['error'], "errNum"=>$validator['errNum']]);
    
            $video =videoBlogs::find($videoBlogId);
            $videoDeleted = $this->videoService->deleteVideoFromFileSystem($video);
            if($videoDeleted['status']==false)
                throw new \ErrorException('cant delete the video file');
            
            $uploadedVideo = $this->videoService->uploadVideoToFileSystem($request->video);
            if($uploadedVideo['status']==false)
                throw new  \ErrorException($uploadedVideo['message']);
            $replaceVideo = $this->videoService->replaceVideo($video, $uploadedVideo['fileName'], $request);
            if($replaceVideo['status']==false)
                throw new \ErrorException($replaceVideo['message']);
    
            return response()->json(["status"=>true, "message"=>"video is updated successfully"]);
    
            }catch (\Exception $exception) {
                return  response()->json(["status"=>false, "message"=>$exception->getMessage()]);
        }
    }

    public function deleteVideoBlog(Request $request, $videoBlogId){
       
         try{

            $video =videoBlogs::find($videoBlogId);
            $videoDeleted = $this->videoService->deleteVideoFromFileSystem($video);
            $this->videoService->deleteVideoFromDataBase($videoBlogId);    
            return response()->json(["status"=>true, "message"=>$videoDeleted['message']]);
            
         }
         catch (\Exception $exception) {
             return  response()->json(["status"=>false, "message"=>$exception->getMessage()]);
         }
    
    }



    
}
