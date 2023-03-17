<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\textBlogs;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class checkTextBlogExist
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
        $textBlogExist = textBlogs::find($request->textBlogId);
        if(!$textBlogExist)
            return  $this -> returnError('404', 'this article is not exist');
        return $next($request);
    }
}
