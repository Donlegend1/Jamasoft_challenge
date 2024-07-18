<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['admin', 'user']),
        ];
    }

    /**
     * Indicate that the role is an admin role.
     *
     * @return \Database\Factories\RoleFactory
     */
    public function admin(): RoleFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
            ];
        });
    }

    /**
     * Indicate that the role is a user role.
     *
     * @return \Database\Factories\RoleFactory
     */
    public function user(): RoleFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'user',
            ];
        });
    }
}