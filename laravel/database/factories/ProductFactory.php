<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $productions = [
            'Galaxy Book 4 Pro',
            'iPhone 16 Pro Max',
            'Dell XPS 15',
            'Galaxy Watch 7',
            'Lenovo Yoga Slim',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($productions),
            'category_id' => Category::factory(), // Para os testes, se não especificarmos uma categoria, a factory criará uma nova automaticamente.
            'brand_id'    => Brand::factory(), // O mesmo para a marca.
        ];
    }
}
