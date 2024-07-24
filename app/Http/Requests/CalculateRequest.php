<?php

namespace App\Http\Requests;

use App\Services\Math\Facade\Math;
use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends FormRequest
{
    public final const string REGEX = '/\(\d+[\+\-\*\/]\d+\)|\(\(\d+[\+\-\*\/]\d+\)[\+\-\*\/]\d+\)/';

    public function rules(): array
    {
        $regex = self::REGEX;

        return [
            'calculation' => ['required', 'string', "regex:{$regex}"],
        ];
    }

    public function pattern():string
    {
        return self::REGEX;
    }

    protected function prepareForValidation(): void
    {
        $this->replace(['calculation' => Math::sanitize($this->input('calculation'))]);
    }
}
