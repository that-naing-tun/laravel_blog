<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'intro', 'body'];
    protected $with = ['category', 'author'];

    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orwhere('body', 'LIKE', '%' . $search . '%');
            });
            // $query->where('title', 'LIKE', '%' . $search . '%')
            //     ->orwhere('body', 'LIKE', '%' . $search . '%');
        });

        $query->when($filter['category'] ?? false, function ($query, $slug) {
            $query->whereHas('category', function ($query) use ($slug) {
                $query->where('slug', $slug);
            });
        });

        $query->when($filter['username'] ?? false, function ($query, $username) {
            $query->whereHas('author', function ($query) use ($username) {
                $query->where('username', $username);
            });
        });

        // $query = Blog::latest();
        // $query->when(request('search'), function ($query, $search) {
        //     $query->where('title', 'LIKE', '%' . $search . '%')
        //         ->orwhere('body', 'LIKE', '%' . $search . '%');
        // });
        // return $query->get();

        // if (request('search')) {
        //     $blogs = $blogs->where('title', 'LIKE', '%' . request('search') . '%')
        //         ->orwhere('body', 'LIKE', '%' . request('search') . '%');
        // }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'blog_user', 'blog_id', 'user_id');
    }

    public function unSubscribe()
    {
        $this->subscribers()->detach(auth()->id());
    }

    public function subscribe()
    {
        $this->subscribers()->attach(auth()->id());
    }
}
