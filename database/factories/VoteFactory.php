<?php

namespace Database\Factories;

use App\Models\Vote;
use App\Models\User;
use App\Models\Website;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Vote::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'website_id' => Website::factory(),
        ];
    }
}