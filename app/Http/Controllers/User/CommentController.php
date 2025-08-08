<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
        public function index(Request $request)
        {
            $taskListId = $request->query('task_list_id');

            $comments = Comment::with(['user', 'replies'])
                ->where('task_list_id', $taskListId)
                ->whereNull('parent_id')
                ->latest()
                ->get();

            return response()->json($comments);
        }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_list_id' => 'required|exists:task_lists,id',
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'task_list_id' => $validated['task_list_id'],
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'content' => $comment->content,
            'user' => $comment->user->name,
            'replies' => $comment->replies
        ]);
    }

    public function show(Comment $comment)
    {
        return response()->json($comment->load(['user', 'replies']));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate(['content' => 'required|string']);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->update(['content' => $request->input('content')]);

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
