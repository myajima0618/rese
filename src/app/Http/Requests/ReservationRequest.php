<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\CarbonImmutable;


class ReservationRequest extends FormRequest
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
            'date' => ['required', 'date_format:Y/m/d,Y-m-d', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'number' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'date.date_format' => 'Y/m/dまたはY-m-d形式で入力してください。',
            'date.after_or_equal' => '本日以降の日付で入力してください。',
            'time.date_format' => 'H:i形式で入力してください。',
            'number.string' => '文字列で入力してください。'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = CarbonImmutable::parse($this->date);
            $time = CarbonImmutable::parse($this->time);

            // 今日の日付で、時間が現在時刻より前であればエラー
            if ($date->isToday() && $time->lt(now())) {
                $validator->errors()->add('time', '時間は現在時刻より後にしてください。');
            }
        });
    }
}
