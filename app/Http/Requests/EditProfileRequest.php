<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
        return [
            'file' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email:rfc,dns|unique:users,id,'.request()->user()->id,
            'phone' => 'required|string|max:255',
            'bio' => 'required|string|max:255',
            'gender_id' => 'required|exists:genders,id',
            'delete_file' => 'sometimes',
        ];
    }
}
