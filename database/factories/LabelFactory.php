<?php

namespace Database\Factories;

use App\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Label>
 */
class LabelFactory extends Factory
{
    protected $model = Label::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
