<div>
    <header>
        <h1>Filtro de Produtos</h1>
    </header>

    {{-- SEÇÃO DE FILTROS --}}
    <article>
        <header><strong>Filtros</strong></header>

        <div class="name-filter-container">
    
            <div>
                <label for="name">
                    <strong>Nome do Produto</strong>
                </label>
                
                <div class="input-group">
                    <input 
                        type="text" 
                        id="name" 
                        wire:model.live.debounce.300ms="name" 
                        placeholder="Ex: celular, notebook..."
                    >

                    <button wire:click="clearFilters">
                        Limpar Filtros
                    </button>
                </div>

            </div>

        </div>


        <div class="grid">
            {{-- Filtro por Categoria --}}
            <fieldset>
                <legend><strong>Categorias</strong></legend>
                @foreach ($categories as $category)
                    <label>
                        <input 
                            type="checkbox" 
                            wire:model.live="selectedCategories" 
                            value="{{ $category->id }}"
                        >
                        {{ $category->name }}
                    </label>
                @endforeach
            </fieldset>

            {{-- Filtro por Marca --}}
            <fieldset>
                <legend><strong>Marcas</strong></legend>
                @foreach ($brands as $brand)
                    <label>
                        <input 
                            type="checkbox" 
                            wire:model.live="selectedBrands" 
                            value="{{ $brand->id }}"
                        >
                        {{ $brand->name }}
                    </label>
                @endforeach
            </fieldset>
        </div>
    </article>

    {{-- SEÇÃO DE RESULTADOS --}}
    <div wire:loading.class="blur">
        <table>
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Marca</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->brand->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">Nenhum produto encontrado com os filtros atuais.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Links de Paginação --}}
        <div style="margin-top: 1rem;">
            {{ $products->links() }}
        </div>
    </div>
    
    {{-- Efeito de carregamento --}}
    <style>
        .blur {
            filter: blur(2px);
            transition: filter 0.2s ease;
        }
        /* Agrupa o input e o botão para alinhamento */
        .input-group {
            display: flex;          /* Coloca os itens lado a lado */        
            gap: 8px;               /* Espaço entre o input e o botão */
        }
        
        /* Garante que o input e o botão tenham a mesma altura */
        .input-group input,
        .input-group button {        
            height: 60px; /* Define uma altura fixa para ambos */
        }
        
        /* Estilo para o botão */
        .input-group button {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            cursor: pointer;
            white-space: nowrap;
        }

        /* Estilo para o botão quando desabilitado */
        .input-group button:disabled {
            background-color: #d3d3d3;
            border-color: #d3d3d3;
            color: #888;
            cursor: not-allowed;
        }

    </style>
</div>