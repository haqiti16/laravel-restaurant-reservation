<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservationCreateRequest extends FormRequest
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
        return [
            "table_id"      => ['required', 'integer'],
            "start_time"    => ['required', 'date_format:Y-m-d\TH:i:s'],
            "end_time"      => ['required', 'date_format:Y-m-d\TH:i:s'],
            "guest_count"   => ['required', 'integer'],
            "name"          => ['required', 'string', 'max:100'],
            "email"         => ['required', 'string', 'max:200'],
            "phone_number"  => ['required', 'string', 'max:20'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag()
        ], 400));
    }
}
