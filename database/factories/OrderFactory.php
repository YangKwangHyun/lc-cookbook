<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::get()->random()->id,
            'total'      => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31'),
            'updated_at' => $this->faker->dateTimeBetween('2023-01-01', '2023-12-31'),
        ];
    }
}
