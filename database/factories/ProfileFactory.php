<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory(),
            'firstname'  => $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'lastname'   => $this->faker->lastName(),
            'contact_no' => $this->faker->e164PhoneNumber(),
            'address'    => $this->faker->address(),
            'balance'    => $this->faker->numberBetween(0, 100)
        ];
    }
}
