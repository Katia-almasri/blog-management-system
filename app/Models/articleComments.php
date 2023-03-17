<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleComments extends Model
{
    use HasFactory;

    protected $table = 'article_comments';
    protected $primaryKey='id';
    protected $fillable = [
         'user_id', 
         'article_id',
         'content'

    ];

    #################### Begin Relations ##########################
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function textBlogs(){
        return $this->hasMany('App\Models\textBlogs', 'article_id', 'id');
    }

    #################### End Relations ##########################

    ############################# Begin usedRepoFunctione ######################

     public function getAll()
     {
         return static::all();
     }
 
 
     public function findArticleComment($id)
     {
         return static::find($id);
     }
 
 
     public function deleteArticleComment($id)
     {
         return static::find($id)->delete();
     }
 
     public function create(Request $request){
 
     }
 
     ############################# End usedRepoFunctione ########################
}
