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

    public function destroy(Comment $comment)
    {
        // Yetkilendirme kontrolü
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        $comment->delete();

        return back()->with('success', 'Yorum başarıyla silindi.');
    }

    public function update(Request $request, Comment $comment)
    {
        // Yetkilendirme kontrolü
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Bu işlem için yetkiniz yok.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Yorumunuz başarıyla güncellendi.');
    }
} 