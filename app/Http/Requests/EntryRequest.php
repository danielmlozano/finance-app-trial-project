<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $entry = $this->entry;
        if (strtoupper($this->method()) === 'POST') {
            return true;
        } else {
            return $user->can('update', $entry);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required',
            'date' => 'required',
            'amount' => 'required|numeric'
        ];
    }
}
