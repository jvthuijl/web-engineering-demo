<?php

namespace App\Http\Requests;

use App\Note;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreNote extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Note $note
     * @param User $user
     * @return bool
     */
    public function authorize(Note $note, User $user)
    {
        return ($note->author() === $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'repo_id' => 'required',
            'content' => 'required',
        ];
    }
}
