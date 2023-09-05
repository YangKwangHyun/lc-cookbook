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
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', '2021-01-01 00:00:00');
        $endDate   = Carbon::createFromFormat('Y-m-d H:i:s', '2021-12-31 23:59:59');

        return [
            'user_id'    => User::get()->random()->id,
            'total'      => $this->faker->randomNumber(),
            'created_at' => $this->faker->dateTimeBetween($startDate, $endDate),
            'updated_at' => $this->faker->dateTimeBetween($startDate, $endDate),
        ];
    }
}
