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
    /**
     * Display all resources.
     *
     * @param $repositoryId int
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($repositoryId) {
        $notes = QueryBuilder::for(Note::class)
            ->allowedFilters(['content'])
            ->whereRepoId($repositoryId)
            ->whereUserId(Auth::user()->id)
            ->get();

        return NoteResource::collection($notes)->additional(['success' => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param             $repositoryId
     * @param NoteRequest $request
     *
     * @return NoteResource
     */
    public function store($repositoryId, NoteRequest $request)
    {
        $validated = $request->validated();

        $note = new Note([
            'content' => $validated['content'],
        ]);
        $note->user_id = \Auth::user()->id;
        $note->repo_id = $repositoryId;
        $note->save();

        return (new NoteResource($note))->additional(['success' => true]);
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

        return (new NoteResource($note))->additional(['success' => true]);
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

        return (new NoteResource($note))->additional(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($repositoryId, Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return ['success' => true];
    }
}
