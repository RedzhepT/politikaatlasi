<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'article_id' => 'required|exists:articles,id'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'article_id' => $validated['article_id'],
            'content' => $validated['content'],
            'is_approved' => true
        ]);

        return back()->with('success', 'Yorumunuz başarıyla eklendi.');
    }
} 