<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReservationFactory extends Factory
{
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
            'user_id' => $this->faker->numberBetween(4, 8),
            'shop_id' => $this->faker->numberBetween(1, 20),
            'date' => $this->faker->dateTimeBetween('-3 months', '2 months')->format('Y-m-d'),
            'time' => $time->toTimeString(),
            'number' => $this->faker->numberBetween(1, 10),
        ];
    }
}
