<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Cache the data instead of the view
        $data = Cache::remember('home.data', 3600, function () {
            return [
                'articles' => Article::with('category')
                    ->where('is_published', true)
                    ->latest()
                    ->take(6)
                    ->get(),
                'categories' => Category::withCount('articles')
                    ->orderByDesc('articles_count')
                    ->take(6)
                    ->get(),
                'stats' => [
                    'articleCount' => Article::count(),
                    'categoryCount' => Category::count(),
                    'authorCount' => User::count(),
                    'viewCount' => Article::sum('views') ?? 0
                ]
            ];
        });

        // Return the view with cached data
        return view('home')
            ->with('articles', $data['articles'])
            ->with('categories', $data['categories'])
            ->with($data['stats']);
    }
}
