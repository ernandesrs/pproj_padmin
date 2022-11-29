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
            'title' => $this->faker->text([25, 26, 24][rand(0, 2)]),
            'description' => $this->faker->text([80, 90][rand(0, 1)]),
            'icon' => json_encode([
                "source" => "local",
                "name" => ["collection", "app", "appIndicator", "home"][rand(0, 3)],
                "class" => null,
                "position" => "start"
            ]),
        ];
    }
}
