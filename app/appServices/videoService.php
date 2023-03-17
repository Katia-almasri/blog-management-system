<?php 
namespace App\appServices;

use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\GeneralTrait;
use App\Models\videoBlogs;
use Illuminate\Http\Request;
use Storage;


class videoService{

    use GeneralTrait;

    public function uploadVideoToFileSystem($video){
            
        $saveFile = $this->saveVideoFile($video, 'storage/videos');
        if($saveFile->original['status']==false)
            return ["status"=>false, "message"=>$saveFile->original['message']]; 
        return ["status"=>true, "fileName"=>$saveFile->original['fileName'], "filePath"=>$saveFile->original['filePath']]; 

    }

    public function addVideoToDB($title, $fileName, $filePath, $user_id){

        try{

            DB::beginTransaction();

                $newVideo = new videoBlogs();
                $newVideo->title = $title;
                $newVideo->video_name = $fileName;
                $newVideo->videoPath = $filePath;
                $newVideo->user_id = $user_id;
                $newVideo->save();

             DB::commit();
            //event needed 
            return  ["status"=>true, "message"=>"video added successfully to database ", "video"=>$newVideo];

        }catch (\Exception $exception) {
            DB::rollback();
            return  ["status"=>false, "message"=>$exception->getMessage()];
        }

    }

    public function findVideo($videoBlogId){
        $video = videoBlogs::find($videoBlogId);
        return  ["status"=>true, "message"=>$video];
       
    }

    public function deleteVideoFromFileSystem($video){
        try{

            Storage::delete('public/videos/'.$video->video_name);
            return  ["status"=>true, "message"=>"video deleted successfully from the file system"];

        }catch (\Exception $exception) {
            return  ["status"=>false, "message"=>"error in deleting video from the file system"];
        }
    }

    public function replaceVideo($originalVideo, $fileName, $request){
        try{
            DB::beginTransaction();
                $originalVideo->video_name = $fileName;
                $originalVideo->title = $request->title;
                $originalVideo->save();
            DB::commit();
            return  ["status"=>true, "message"=>"video updated successfully in database"];

        }catch (\Exception $exception) {
            DB::rollback();
            return  ["status"=>false, "message"=>$exception->getMessage()];
        }
    }

    public function deleteVideoFromDataBase($videoBlogId){
        $video = videoBlogs::where('id', '=', $videoBlogId)->delete();
        return  ["status"=>true, "message"=>"video deleted successfully from database"];
    }

}
