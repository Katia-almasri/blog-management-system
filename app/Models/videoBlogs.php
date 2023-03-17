<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class videoBlogs extends Model
{
    use HasFactory;

    protected $table = 'video_blogs';
    protected $primaryKey='id';
    protected $fillable = [
         'user_id', 
         'title',
         'video_path',
         'video_name'

    ];

    #################### Begin Relations ##########################
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    #################### End Relations ##########################
}
