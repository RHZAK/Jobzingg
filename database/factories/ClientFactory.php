<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'          => 'a3378c4a-4a0e-4b09-9217-165be3857796',
            'user_id'     => 'ee3f32a5-1d92-4fba-bc76-a95a5201d88d',
            'country_id'  => '148',
            'name'        => $this->faker->name(),
            'email'       => $this->faker->email(),
            'phone'       => $this->faker->phoneNumber(),
            'address'     => $this->faker->address(),
            'image'       => 'img/profile-icon.jpg',
        ];
    }
}
