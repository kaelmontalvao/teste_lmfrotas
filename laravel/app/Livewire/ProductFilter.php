<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ProductFilter extends Component
{
    use WithPagination;

    // Se o campo estiver vazio, não polua a URL. Só coloca na URL quando tiver algum valor.
    #[Url(except: '')]
    public string $name = '';

    #[Url(except: [])]
    public array $selectedCategories = [];

    #[Url(except: [])]
    public array $selectedBrands = [];

    /**
     * Limpa todos os filtros e reseta a paginação.
     */
    public function clearFilters()
    {
        $this->reset();
        $this->resetPage(); // Reseta a paginação para a primeira página
    }

    public function render()
    {
        // Inicia a query de produtos
        $productsQuery = Product::query();

        // Aplica o filtro de nome do produto
        if ($this->name) {
            $productsQuery->where('name', 'like', '%' . $this->name . '%');
        }

        // Aplica o filtro de categorias selecionadas        
        if ($this->selectedCategories) {
            $productsQuery->whereIn('category_id', $this->selectedCategories);
        }

        // Aplica o filtro de marcas selecionadas
        if ($this->selectedBrands) {
            $productsQuery->whereIn('brand_id', $this->selectedBrands);
        }
        
        return view('livewire.product-filter', [
            'products' => $productsQuery->simplePaginate(10),
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }
}