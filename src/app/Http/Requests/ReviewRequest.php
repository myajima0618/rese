<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['string', 'nullable']
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '必須項目です',
            'rating.integer' => '整数を指定してください',
            'rating.min' => '1以上の整数を指定してください',
            'rating.max' => '5以下の整数を指定してください',
            'comment.string' => '文字列で入力してください'
        ];
    }
}
