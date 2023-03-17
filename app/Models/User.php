<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     #################### Begin Relations ##########################
     public function textBlogs(){
        return $this->hasMany('App\Models\TextBlogs', 'user_id', 'id');
    }

    public function videoBlogs(){
        return $this->hasMany('App\Models\videoBlogs', 'user_id', 'id');
    }

    public function comments(){
        return $this->hasMany('App\Models\articleComments', 'user_id', 'id');
    }

    #################### End Relations #########################################

    ############################# Begin usedRepoFunctione ######################

        public function getAll()
        {
            return static::all();
        }
    
    
        public function findUser($id)
        {
            return static::find($id);
        }
    
    
        public function deleteUser($id)
        {
            return static::find($id)->delete();
        }
    
        public function create(Request $request){
    
        }
    
        ############################# End usedRepoFunctione ########################
    
}
