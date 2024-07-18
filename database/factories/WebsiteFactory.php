<?php

namespace Database\Factories;

use App\Models\Website;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Website>
 */
class WebsiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Website::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'url' => $this->faker->url,
            'user_id' => 1,
            'description' => $this->faker->paragraph,
        ];
    }
}