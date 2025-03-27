<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
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
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'event_date'  => ['required', 'date', 'date_format:Y-m-d', 'after:today'],
            'start_time'  => ['required', 'date_format:H:i'],
            'end_time'    => ['required', 'date_format:H:i', 'after:start_time'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'price'       => ['required', 'numeric', 'min:1'],
            'location'    => ['required', 'string', 'max:255'],
            'image'       => ['nullable', 'image'],
            'status'      => ['sometimes', 'string', 'max:255'],
        ];
    }

    public function rulesForUpdate(): array
    {
        return [
            'title'       => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:500'],
            'event_date'  => ['sometimes', 'date', 'date_format:Y-m-d', 'after:today'],
            'start_time'  => ['sometimes', 'date_format:H:i'],
            'end_time'    => ['sometimes', 'date_format:H:i', 'after:start_time'],
            'capacity'    => ['sometimes', 'integer', 'min:1'],
            'price'       => ['sometimes', 'numeric', 'min:1'],
            'location'    => ['sometimes', 'string', 'max:255'],
            'image'       => ['sometimes', 'image'],
            'status'      => ['sometimes', 'string', 'max:255']
        ];
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_time.date_format' => 'The start time must be in the correct format (HH:MM).',
            'end_time.date_format' => 'The end time must be in the correct format (HH:MM).',
        ];
    }
}
