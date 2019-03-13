<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNote;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return $user->notes();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNote $request)
    {
        $validated = $request->validated();
        $note = Note::create([
            'repo_id' => $validated['repo_id'],
            'content' => $validated['content'],
            'user_id' => Auth::user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::findOrFail($id);
        if ($note->author != Auth::user()) {
            return response()->json(['error' => true, 'message' => 'Forbidden.'], 403);
        }
        return $note;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);
        if ($note->author() != Auth::user()) {
            return response()->json(['error' => true, 'message' => 'Forbidden.'], 403);
        }
    }
}
