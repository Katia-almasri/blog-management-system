<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class textBlogs extends Model
{
    use HasFactory;

    protected $table = 'text_blogs';
    protected $primaryKey='id';
    protected $fillable = [
         'user_id', 
         'title',
         'details'

    ];

    #################### Begin Relations ##########################
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function comments(){
        return $this->hasMany('App\Models\articleComments', 'text_blog_id', 'id');
    }

    #################### End Relations ##########################

    
}
