<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $comments = Comment::with('article')
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment): View
    {
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $comment->update($validated);

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Approve the specified comment.
     */
    public function approve(Comment $comment): RedirectResponse
    {
        $comment->status = 'approved';
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil disetujui.');
    }

    /**
     * Reject the specified comment.
     */
    public function reject(Comment $comment): RedirectResponse
    {
        $comment->status = 'rejected';
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil ditolak.');
    }
}
