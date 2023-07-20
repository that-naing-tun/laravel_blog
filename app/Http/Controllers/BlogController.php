<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blogs.index', [
            'blogs' => Blog::latest()
                ->filter(request(['search', 'category', 'username']))
                ->paginate(6)
                ->withQueryString()
        ]);
    }


    public function show(Blog $blog)
    {
        return view('blogs.show', [
            'blog' => $blog,
            'randomBlogs' => Blog::inRandomOrder()->take(3)->get()
        ]);
    }

    public function subscriptionHander(Blog $blog)
    {
        // return $blog->slug;
        if (User::find(auth()->id())->isSubscribed($blog)) {
            // dd('that');
            $blog->unSubscribe();
            // return redirect()->back();
        } else {
            $blog->subscribe();
            // return redirect()->back();
        }
        return back();
    }
}


//all -> index -> blogs.index
//single -> show -> blogs.show
//create -> create -> --
//data store -> store -> blogs.store
//edit form -> edit -> blogs.edit
// server update -> update -> --
