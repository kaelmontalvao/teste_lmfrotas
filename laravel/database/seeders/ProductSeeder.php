<?php
namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Defina as listas de Marcas e Categorias.
        $categoryNames = [
            'Celular', 'Notebook', 'Tablet', 'Smartwatch'
        ];
        $brandNames = [
            'Samsung', 'Apple', 'Dell', 'Lenovo'
        ];

        // 2. Garanta que todas as marcas e categorias existam no banco de dados.
        // O método firstOrCreate evita duplicatas se o seeder for executado novamente.
        foreach ($categoryNames as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
        foreach ($brandNames as $name) {
            Brand::firstOrCreate(['name' => $name]);
        }

        // 3. Busque todos os registros.
        $allCategories = Category::all();
        $allBrands = Brand::all();

        $this->command->info("Criando 4 produtos por categoria...");

        // 4. Loop principal: para cada categoria, crie 4 produtos.
        foreach ($allCategories as $category) {
            // 5. Para cada categoria, sorteie 4 marcas ÚNICAS da nossa lista de marcas.            
            $brandsForThisCategory = $allBrands->shuffle()->take(4);

            // 6. Loop secundário: para cada uma das 4 marcas sorteadas, crie um produto.
            foreach ($brandsForThisCategory as $brand) {
                
                // Gera um nome de produto combinando a marca e categoria.
                $productName = "{$brand->name} {$category->name} " . fake()->bothify('Modelo ??-###');

                Product::firstOrCreate(
                    ['name' => $productName], // Condição para evitar duplicatas
                    [
                        'brand_id' => $brand->id,
                        'category_id' => $category->id,
                    ]
                );
            }
        }
        
        // Contagem de produtos.
        $productCount = Product::count();
        $this->command->info("Catálogo criado com sucesso! Total de produtos: {$productCount}.");
    }
}