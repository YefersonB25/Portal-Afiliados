<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_parentesco' => 0,
            'photo' => '',
            'name' => $this->faker->name(),
            'identification' => '39684019',
            'email' => $this->faker->unique()->safeEmail(),
            'identificationPhoto' => '',
            'telefono' => '',
            'seleccion_nit' => '',
            'estado' => 2,
            'email_verified_at' => now(),
            'password' => bcrypt($password = '123456'), // password
            'remember_token' => Str::random(10),
            // 'is_admin' => true,
            // 'is_staff' => true,
        ];
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
