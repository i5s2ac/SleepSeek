<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'number' => ["nullable", 'string', 'regex:/^[0-9\-\+\(\)\s]+$/i', 'max:20'],
            'birthday' => ["nullable",'date', 'before:today', 'after:1900-01-01'],
            'gender' => ["nullable",'string', 'in:masculino,femenino,other'],
            'country' => ["nullable",'string', 'in:Guatemala,Estados Unidos,México'],
            'direction' => ["nullable", 'string', 'max:255'],
            'dpi_photo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'DPI' => ["nullable", 'string', 'max:13'],
        ];
    }
}
