<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request) {
        return response()->json(['success' => true, 'notes' => $request->user()->notes()->orderBy('updated_at', 'desc')->get()]);
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string', 
            'body' => 'nullable|string', 
            'tag' => 'nullable|string', 
            'trip_id' => 'nullable|exists:trips,id'
        ]);
        $note = $request->user()->notes()->create($validated);
        return response()->json(['success' => true, 'message' => 'Note created.', 'note_id' => $note->id]);
    }
    
    public function show(Request $request, Note $note) {
        if ($note->user_id !== $request->user()->id) abort(403);
        return response()->json(['success' => true, 'note' => $note]);
    }
    
    public function update(Request $request, Note $note) {
        if ($note->user_id !== $request->user()->id) abort(403);
        $note->update($request->only(['title', 'body', 'tag']));
        return response()->json(['success' => true, 'message' => 'Note updated.']);
    }
    
    public function destroy(Request $request, Note $note) {
        if ($note->user_id !== $request->user()->id) abort(403);
        $note->delete();
        return response()->json(['success' => true, 'message' => 'Note deleted.']);
    }
}