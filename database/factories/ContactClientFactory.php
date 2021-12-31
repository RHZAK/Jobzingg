<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactClientFactory extends Factory
{


    public function definition()
    {
        return [
            'id'          => 'a3378c4a-4a0e-4b09-9217-165be3857792',
            'client_id'   => 'a3378c4a-4a0e-4b09-9217-165be3857796',
            'first_name'  => $this->faker->name(),
            'last_name'   => $this->faker->name(),
            'poste'       => $this->faker->address(),
            'email'       => $this->faker->email(),
            'phone'       => $this->faker->phoneNumber(),
        ];
    }
}
