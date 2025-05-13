<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\Reservation;
use App\Models\Review;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hour = $this->faker->numberBetween(12, 22);
        $time = Carbon::createFromFormat('H:i', sprintf('%02d:00', $hour));
        return [
            'user_id' => $this->faker->numberBetween(4, 13),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'date' => $this->faker->dateTimeBetween('-3 months', '1 months')->format('Y-m-d'),
            'time' => $time->toTimeString(),
            'number' => $this->faker->numberBetween(1, 10),
        ];
    }
    
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Reservation $reservation) {
            // Fakerインスタンスを日本語ロケールで作成
            $fakerJa = \Faker\Factory::create('ja_JP');
            // 一定の確率でレビューを作成する例
            if ($this->faker->boolean(80)) { // 80%の確率でレビューを作成
                Review::factory()->create([
                    'reservation_id' => $reservation->id,
                    'shop_id' => $reservation->shop_id,
                    'user_id' => $reservation->user_id,
                    'comment' => $fakerJa->text(), // 日本語ロケールのFakerを使用
                ]);
            }
        });
    }
}
