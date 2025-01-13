<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $articles = Article::query()
            ->where('is_published', true)
            ->latest()
            ->paginate(6)
            ->through(function ($article) {
                $article->excerpt = Str::words(strip_tags($article->content), 10);
                return $article;
            });

        return view('home', compact('articles'));
    }
}
