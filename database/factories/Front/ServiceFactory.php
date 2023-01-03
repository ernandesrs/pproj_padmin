<?php

namespace Database\Factories\Front;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(20),
            'description' => $this->faker->text(80),
            'icon' => json_encode([
                "source" => "local",
                "name" => ["collection", "app", "appIndicator", "home"][rand(0, 3)],
                "class" => null,
                "position" => "start"
            ]),
        ];
    }
}
