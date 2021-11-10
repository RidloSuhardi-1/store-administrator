<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(mt_rand(3,8)),
            'address' => $this->faker->text(50),
            'phone' => $this->faker->unique()->phoneNumber()
        ];
    }
}
