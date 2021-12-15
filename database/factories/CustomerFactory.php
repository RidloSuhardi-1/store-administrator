<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Umum',
            'slug' => 'umum',
            'address' => $this->faker->text(5),
            'phone' => $this->faker->unique()->phoneNumber()
        ];
    }
}
