<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
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
    public function store(NoteRequest $request)
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
     * @return NoteResource
     */
    public function show($id)
    {
        $note = Note::findOrFail($id);
        $user = Auth::user();
        if ($user->can('view', $note)) {
            return response()->json(['error' => true, 'message' => 'Forbidden.'], 403);
        }
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NoteRequest $request
     * @param  int $id
     * @return mixed
     */
    public function update(NoteRequest $request, $id)
    {
        $validated = $request->validated();
        return new NoteResource(Note::updateOrCreate($validated));
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
        $user = Auth::user();
        if ($user->can('delete', $note)) {
            return response()->json(['error' => true, 'message' => 'Forbidden.'], 403);
        }
    }
}
