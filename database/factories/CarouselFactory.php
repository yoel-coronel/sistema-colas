<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarouselFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>'FOVIPOL',
            'tiempo'=>time(),
            'path'=>'video/REFINANCIAMIENTO.mp4',
            'class_default'=>'active',
            'is_active'=>1
        ];
    }
}
