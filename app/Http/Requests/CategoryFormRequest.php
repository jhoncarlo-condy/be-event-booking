<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->user_role_id == UserRole::where('name', 'admin')->first()->id;
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

    public function rulesForCreate(): array
    {
        return [
            'name' => ['required', Rule::unique('categories', 'name')]
        ];
    }

    public function rulesForUpdate(): array
    {
        return [
            'name' => ['required', Rule::unique('categories', 'name')->ignore($this->category->id)]
        ];
    }
}
