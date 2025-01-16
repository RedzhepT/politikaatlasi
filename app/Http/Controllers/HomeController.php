<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $articles = Article::with('category')
            ->where('is_published', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('articles')
            ->orderByDesc('articles_count')
            ->take(6)
            ->get();

        $stats = [
            'articleCount' => Article::count(),
            'categoryCount' => Category::count(),
            'authorCount' => User::count(),
            'viewCount' => Article::sum('views') ?? 0
        ];

        return view('home', compact('articles', 'categories'))->with($stats);
    }
}
