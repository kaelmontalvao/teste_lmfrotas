# Projeto Filtro de Produtos com Livewire e Docker

Olá! 👋 Bem-vindo a este projeto de demonstração de utilização de filtros.

O objetivo aqui é mostrar um sistema de filtragem de produtos dinâmico e interativo, construído com o poder do **Laravel** e do **Livewire**. Todo o ambiente de desenvolvimento está containerizado com **Docker**, facilitando a configuração e a execução em qualquer máquina.

---

### ✨ Tecnologias Utilizadas

* **Back-end:** Laravel 10
* **Front-end Interativo:** Livewire 3
* **Ambiente de Desenvolvimento:** Docker & Docker Compose (com Apache e MySQL)
* **Testes:** Pest (um framework de testes para PHP com foco em simplicidade)
* **Estilo (opcional):** Picocss

---

### 🚀 Como Começar (Guia de Instalação)

Para rodar este projeto na sua máquina, siga estes passos simples.

#### Pré-requisitos
* [Git](https://git-scm.com/)
* [Docker](https://www.docker.com/products/docker-desktop/)
* Docker Compose

#### 1. Clonar o Repositório
Abra seu terminal e clone o projeto para a sua máquina.

```bash
git clone git@github.com:kaelmontalvao/teste_lmfrotas.git && cd teste_lmfrotas
```

#### 2. Configurar o Ambiente (`.env`)
O projeto precisa de um arquivo de configuração de ambiente. Nós já deixamos um exemplo pronto para você.

* **Copie o arquivo de exemplo:**
    ```bash
    cp laravel/.env.example laravel/.env
    ```

* **Configuração do Banco de Dados:**
    Substitua a configuração de conexão do banco de dados no arquivo `.env` por essas que já estão corretas para se conectar com o banco de dados do Docker:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=db             # 'db' é o nome do serviço do banco de dados no docker-compose.yml
    DB_PORT=3306
    DB_DATABASE=frotas_db
    DB_USERNAME=frotas_user
    DB_PASSWORD=secret
    ```

#### 3. Subir os Contêineres Docker
Este comando vai construir as imagens e iniciar todos os serviços (aplicação, banco de dados) em segundo plano.

```bash
docker compose up -d --build
```
*(A primeira vez pode demorar um pouco, pois o Docker precisa baixar as imagens base).*

#### 4. Comandos de Finalização
Com os contêineres rodando, precisamos executar alguns comandos do Laravel para deixar tudo pronto.

* **Instalação do composer dentro do container:**
    ```bash
    docker compose exec lm_frotas composer install
    ```
* **Gerar a chave da aplicação (essencial para segurança):**
    ```bash
    docker compose exec lm_frotas php artisan key:generate
    ```
* **Execução da migrations para criar as tabelas:**
    ```bash
    docker compose exec lm_frotas php artisan migrate
    ```
* **Popular o banco de dados com dados de exemplo:**
    ```bash
    docker compose exec lm_frotas php artisan db:seed
    ```
* **(Opcional) Otimizar arquivos de cache:**
    ```bash
    docker compose exec lm_frotas php artisan optimize
    ```
* **Corrigir permissões dos diretórios de cache (obrigatório para o Laravel funcionar corretamente):**
    ```bash
    docker compose exec lm_frotas bash -c "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache"
    ```

#### 5. Acesse o Projeto!
Pronto! Abra seu navegador e acesse o seguinte endereço:

👉 **http://localhost:8000/products**

Você deverá ver a página de filtros de produtos funcionando.

---

### ✅ Testes Automatizados

Para garantir que a funcionalidade de filtros continue funcionando corretamente após qualquer alteração, o projeto conta com a implementação de testes automatizados.

#### O que os testes verificam?

Os testes garantem que as principais regras de negócio do filtro estão funcionando:
* ✅ Se a página de filtros carrega com sucesso.
* ✅ Se o filtro por **nome de produto** funciona corretamente.
* ✅ Se o filtro por uma ou mais **categorias** funciona.
* ✅ Se o filtro **combinado** (nome, marca e categoria ao mesmo tempo) retorna o resultado exato.
* ✅ Se o botão **"Limpar Filtros"** reseta a busca e mostra todos os produtos novamente.

#### Como Rodar os Testes

Para executar a suíte de testes do filtro, rode o seguinte comando no seu terminal:

```bash
docker compose exec lm_frotas php artisan test --filter ProductFilterTest
```

Se tudo estiver correto, você verá uma saída verde indicando que todos os testes passaram!