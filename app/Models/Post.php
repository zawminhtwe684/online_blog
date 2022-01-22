<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
//    protected $with= ['user','category','photos','tags'];  // သူကို relationship ချိတ်ထားတိုင်းမှာပါစေချင်တာပါ

    public function user(){
        return $this->belongsTo(User::class);
    }
    //one to one inverse= belongsTo  post->user_id->user
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //one to many= hasMany
    public function photos(){
        return $this->hasMany(Photo::class);
    }

    //many to many == post->tags | tag->posts
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

// user->post->photo ==hasManyThrough
//    public function photos(){
//        return $this->hasManyThrough(Photo::class,Post::class);
//    }





////observer နဲ့ သဘောတရာအတူတူပဲ
//    protected static function booted()
//    {
//       static::created(function(){
////           send mail
//            logger('Zaw Min Htwe');
//
//       });
////       static::deleted(function(){});
////       static::updated(function(){});
//
//    }





//query scope ->local scope
public function scopeSearch($query){
        if(isset(request()->search)){
            $search =request()->search ;
            return $query->where('title', "LIKE", "%$search%")->orWhere('description', "LIKE", "%$search%");
        }
}

}
