<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user_id = $this->user->id ?? null;
        return [
            'pseudo' => 'nullable|max:12',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8',
            'picture' => 'nullable',
            'banner' => 'nullable',
            'phone' => 'nullable|numeric',
            'description' => 'nullable',
        ];
    }
}
