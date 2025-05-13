<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;


class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Fakerインスタンスを日本語ロケールで作成
        $fakerJa = \Faker\Factory::create('ja_JP');

        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $fakerJa->text(),
            'review_image' => 'https://placehold.jp/500x300.png?text=Rese', // 例としてダミーの画像URL
            'delete_flag' => null,            //
        ];
    }
}
