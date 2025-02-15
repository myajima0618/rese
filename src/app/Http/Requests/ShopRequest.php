<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shop_name' => ['required', 'string', 'max:191'],
            'area_id' => ['required', 'string'],
            'category_id' => ['required', 'string'],
            'user_id' => ['required', 'string'],
            'description' => ['required', 'string', 'max:500'],
            'image_url' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:5120']
        ];
    }

    public function messages()
    {
        return [
            'image_url.file' => '5MB以下の画像(jpeg,png,jpg)を指定してください',
            'image_url.image' => '5MB以下の画像(jpeg,png,jpg)を指定してください',
            'image_url.mimes' => '5MB以下の画像(jpeg,png,jpg)を指定してください',
            'image_url.max' => '5MB以下の画像(jpeg,png,jpg)を指定してください',
        ];
    }

}
