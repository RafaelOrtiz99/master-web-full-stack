<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;

class Post extends Model
{
    protected $table = 'posts';

    //Relación de muchos a uno
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    //Relación de muchos a uno
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
