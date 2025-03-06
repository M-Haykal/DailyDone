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
        $comments = Comment::with(['user', 'taskList', 'parent'])
            ->where('task_list_id', $taskListId)
            ->latest()
            ->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_list_id' => 'required|exists:task_lists,id',
            'content' => 'required|string|max:255',
        ]);
    
        try {
            $comment = new Comment();
            $comment->task_list_id = $validated['task_list_id'];
            $comment->content = $validated['content'];
            $comment->user_id = auth()->id();
            $comment->save();
    
            return response()->json([
                'content' => $comment->content,
                'user' => $comment->user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to post comment'], 500);
        }
    }    

    public function show(Comment $comment)
    {
        return response()->json($comment->load(['user', 'taskList', 'parent']));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->update(['content' => $request->content]);

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
