<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Menu',
            'items' => json_encode([
                [
                    'text' => 'Home',
                    'title' => 'Home page',
                    'target' => '_self',
                    'url' => route('front.index'),
                    'icon' => [
                        'source' => 'local',
                        'name' => 'house',
                        'class' => '',
                        'position' => 'start',
                    ],
                ],
                [
                    'text' => 'Example #1',
                    'title' => 'Menu item example #1',
                    'target' => '_self',
                    'url' => route('front.index'),
                    'icon' => [
                        'source' => 'local',
                        'name' => 'appIndicator',
                        'class' => '',
                        'position' => 'start',
                    ],
                ],
                [
                    'text' => 'Example #2',
                    'title' => 'Menu item example #2',
                    'target' => '_self',
                    'url' => route('front.index'),
                    'icon' => [
                        'source' => 'local',
                        'name' => 'app',
                        'class' => '',
                        'position' => 'start',
                    ],
                ],
            ]),
        ];
    }
}
