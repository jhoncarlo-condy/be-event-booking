<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return request()->isMethod('POST') ? $this->rulesForCreate() : $this->rulesForUpdate();
    }


    public function rulesForCreate()
    {
        return [
            'old_password' => ['required', 'string', 'min:8', 'max:255'],
            'password'     => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ];
    }

    public function rulesForUpdate()
    {
        return [
            'first_name'   => ['sometimes', 'string', 'min:1','max:255'],
            'last_name'    => ['sometimes', 'string', 'min:1','max:255'],
        ];
    }
}
