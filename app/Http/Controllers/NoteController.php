<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class NoteController extends Controller
{
    public function index($repositoryId) {
        $notes = QueryBuilder::for(Note::class)
            ->allowedFilters(['content'])
            ->whereRepoId($repositoryId)
            ->get();

        return NoteResource::collection($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NoteRequest $request
     * @return NoteResource
     */
    public function store($repositoryId, NoteRequest $request)
    {
        $validated = $request->validated();

        $note = Note::create([
            'repo_id' => $repositoryId,
            'content' => $validated['content'],
            'user_id' => Auth::user()->id,
        ]);

        return new NoteResource($note);
    }

    /**
     * Display the specified resource.
     *
     * @param Note $note
     * @return NoteResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Note $note)
    {
        $this->authorize('view', $note);

        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NoteRequest $request
     * @param Note $note
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(NoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validated();
        $note->fill($validated);

        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return ['success' => true];
    }
}
