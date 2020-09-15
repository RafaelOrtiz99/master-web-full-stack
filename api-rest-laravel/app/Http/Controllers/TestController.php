<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class TestController extends Controller
{
    public function index(){
        $animals = ['dog','cat','tiger'];

        return view('tests.index',array(
            'title' => 'Animals',
            'animals' => $animals
        ));
    }

    public function testOrm(){
        $posts = Post::all();

        foreach($posts as $post){
            echo "<h1>" . $post->title . "</h1>";
            echo "<span> {$post->category->name} </span>";
            echo "<hr>";
        }
        

        
        
    
    
    }
}
