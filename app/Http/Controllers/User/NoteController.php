<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index($id = null)
    {
        $note = $id ? Notes::where('user_id', Auth::id())->findOrFail($id) : new Notes();
        return view('user.pages.detail-note-page', compact('note'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $note = Notes::create([
            'title' => $request->title,
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);
    
        return response()->json(['message' => 'Note created successfully!', 'note' => $note]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        $note = Notes::where('user_id', Auth::id())->findOrFail($id);
        $note->update([
            'title' => $request->title,
            'content' => $request->input('content'),
        ]);
    
        return response()->json(['message' => 'Note updated successfully!', 'note' => $note]);
    }    

    public function destroy($id)
    {
        $note = Notes::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->json(['message' => 'Note deleted successfully!']);
    }
}