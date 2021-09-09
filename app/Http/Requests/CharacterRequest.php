<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CreatureRequest;

class CharacterRequest extends CreatureRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(),  [
            'race'=> 'required|max:255',
            'class'=> 'required|max:255',
            'level'=> 'required|integer',
            'current_hp'=> 'required|integer',
            'is_archived'=> 'required|boolean',
            'archive_date'=> 'date|nullable',
        ]);
    }
}
