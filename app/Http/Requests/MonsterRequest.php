<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CreatureRequest;

class MonsterRequest extends CreatureRequest
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
            'size'                  => 'required|max:255',
            'type'                  => 'required|max:255',
            'alignment'             => 'required|max:255',
            'challenge_rating'      => 'required|max:255',
            'experience'            => 'integer',
            'source'                => 'max:255',
            'public'                => 'required|boolean',
        ]);
    }
}
