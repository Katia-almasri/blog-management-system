<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\textBlogs;
use App\Traits\GeneralTrait;

class isAuther
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
        $textBlogExist = textBlogs::find($request->textBlogId);
        if(!$textBlogExist)
            return  $this -> returnError('001', 'this article is not exist');
        else{
            if($textBlogExist->user_id != $user->id)
                return  $this -> returnError('002', 'you are not the author of this blog, you dont`t have permission to edit or delete it');
        }
        return $next($request);
        
    }
}
