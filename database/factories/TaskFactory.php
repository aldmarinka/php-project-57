<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->sentence(),
            'description' => fake()->sentence(),
            'status_id' => $this->faker->numberBetween(1, 4),
            'created_by_id' => User::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];
    }
}
