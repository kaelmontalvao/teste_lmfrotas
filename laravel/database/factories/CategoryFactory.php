<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $categories = [
            'Celulares',
            'Notebooks',
            'Tablets',
            'Smartwatches',
            'Fones de Ouvido',            
        ];

        return [
            // Sorteia uma categoria da lista, garantindo que seja único por execução.
            'name' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
