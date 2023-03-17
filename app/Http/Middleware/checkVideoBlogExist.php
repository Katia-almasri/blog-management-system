<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\videoBlogs;

class checkVideoBlogExist
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
        $videoBlogExist = videoBlogs::find($request->videoBlogId);
        if(!$videoBlogExist)
            return  $this -> returnError('404', 'this video is not exist');
        return $next($request);    }
}
