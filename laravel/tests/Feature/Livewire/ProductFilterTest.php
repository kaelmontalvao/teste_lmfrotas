<?php

namespace Tests\Feature\Livewire;

use PHPUnit\Framework\Attributes\Test;
use App\Livewire\ProductFilter;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se o componente ProductFilter carrega corretamente e exibe o título esperado.
     */
    #[Test]
    public function it_renders_the_component_successfully()
    {
        Livewire::test(ProductFilter::class)
            ->assertStatus(200)
            ->assertSee('Filtro de Produtos');
    }

    /**
     * Testa o filtro por nome de produto.
     * Garante que o componente mostre apenas os produtos cujo nome contém o termo buscado.
     */
    #[Test]
    public function it_filters_by_product_name()
    {
        // Criamos dois produtos com nomes diferentes
        Product::factory()->create(['name' => 'Notebook Super Veloz']);
        Product::factory()->create(['name' => 'Celular Básico']);

        // Aplicamos o filtro e verificamos se o resultado está correto
        Livewire::test(ProductFilter::class)
            ->set('name', 'Notebook Super') // Buscando um termo específico
            ->assertSee('Notebook Super Veloz') // Deve mostrar o produto correspondente
            ->assertDontSee('Celular Básico');  // Não deve mostrar produtos que não correspondem ao filtro
    }

    /**
     * Testa o filtro por categorias.
     * Garante que apenas os produtos pertencentes às categorias selecionadas sejam exibidos.
     */
    #[Test]
    public function it_filters_by_categories()
    {
        // Criamos três categorias diferentes, cada uma com um produto
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();
        $categoryC = Category::factory()->create();

        $productInCatA = Product::factory()->create(['category_id' => $categoryA->id]);
        $productInCatB = Product::factory()->create(['category_id' => $categoryB->id]);
        $productInCatC = Product::factory()->create(['category_id' => $categoryC->id]);

        // Aplicamos o filtro em duas categorias e conferimos os resultados
        Livewire::test(ProductFilter::class)
            ->set('selectedCategories', [$categoryA->id, $categoryB->id])
            ->assertSee($productInCatA->name)
            ->assertSee($productInCatB->name)
            ->assertDontSee($productInCatC->name);
    }

    /**
     * Testa a combinação de filtros por nome, categoria e marca.
     * Garante que apenas o produto que atender a todos os critérios seja exibido.
     */
    #[Test]
    public function it_filters_by_name_and_brand_and_category_combined()
    {
        // Criamos categorias e marcas distintas
        $targetCategory = Category::factory()->create(['name' => 'Celulares']);
        $otherCategory = Category::factory()->create(['name' => 'Notebooks']);

        $targetBrand = Brand::factory()->create(['name' => 'Samsung']);
        $otherBrand = Brand::factory()->create(['name' => 'Apple']);

        // Produto que deve aparecer no filtro
        $targetProduct = Product::factory()->create([
            'name' => 'Galaxy S25',
            'category_id' => $targetCategory->id,
            'brand_id' => $targetBrand->id,
        ]);

        // Produtos que não devem aparecer no resultado
        Product::factory()->create([
            'name' => 'Galaxy Note',
            'category_id' => $targetCategory->id,
            'brand_id' => $otherBrand->id,
        ]);
        Product::factory()->create([
            'name' => 'iPhone 16',
            'category_id' => $otherCategory->id,
            'brand_id' => $targetBrand->id,
        ]);

        // Aplicamos os três filtros juntos e validamos o resultado
        Livewire::test(ProductFilter::class)
            ->set('name', 'Galaxy')
            ->set('selectedCategories', [$targetCategory->id])
            ->set('selectedBrands', [$targetBrand->id])
            ->assertSee($targetProduct->name)
            ->assertDontSee('iPhone 16')
            ->assertDontSee('Galaxy Note');
    }

    /**
     * Testa a funcionalidade de limpar filtros.
     * Garante que os filtros sejam resetados corretamente e que todos os produtos voltem a ser exibidos.
     */
    #[Test]
    public function it_clears_all_filters()
    {
        // Criamos dois produtos para testar o filtro e o reset
        $productA = Product::factory()->create();
        $productB = Product::factory()->create();

        // Primeiro, aplicamos um filtro e verificamos que ele funciona
        Livewire::test(ProductFilter::class)
            ->set('name', $productA->name)
            ->assertSee($productA->name)
            ->assertDontSee($productB->name)

            // Em seguida, limpamos os filtros
            ->call('clearFilters')

            // Confirmamos que todos os filtros foram resetados
            ->assertSet('name', '')
            ->assertSet('selectedCategories', [])
            ->assertSet('selectedBrands', [])

            // Por fim, verificamos que todos os produtos voltaram a aparecer
            ->assertSee($productA->name)
            ->assertSee($productB->name);
    }
}
