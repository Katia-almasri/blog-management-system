<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\videoBlogs;

class checkIsCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    use GeneralTrait;

    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();
        //get id the current user who wrote this article by its id
        $videoBlogExist = videoBlogs::find($request->videoBlogId);
        if(!$videoBlogExist)
            return  $this -> returnError('003', 'this video is not exist');
        else{
            if($videoBlogExist->user_id != $user->id)
                return  $this -> returnError('004', 'you are not the creator of this video, you dont`t have permission to edit or delete it');
        }
        return $next($request);
    }
}
