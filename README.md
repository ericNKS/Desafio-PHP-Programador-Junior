# Desafio PHP com MySQL: Aplicação de Gerenciamento de Produtos

Este projeto é um desafio que envolve a criação de uma aplicação PHP para gerenciamento de produtos utilizando MySQL como banco de dados. O objetivo é demonstrar habilidades de desenvolvimento web, incluindo a utilização de containers Docker para gerenciar o ambiente de desenvolvimento.

## Estrutura do Projeto

Abaixo está a estrutura de diretórios do projeto:
```
├── docker
│   ├── db # Configurações do banco de dados
│   └── nginx # Configurações do servidor Nginx
└── src
    ├── App # Código-fonte da aplicação
    ├── public # Arquivos públicos
    └── vendor # Dependências do Composer
```

## Pré-requisitos

Antes de rodar o projeto, certifique-se de ter os seguintes itens instalados em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)

## Executando o Projeto com Docker

1. Navegue até a pasta `docker`:

    ```bash
    cd docker
    ```

2. Crie o arquivo `.env`:

    ```bash
    make env
    ```

3. Inicie os containers usando o Makefile:

    ```bash
    make up
    ```

4. Após o início dos containers, instale as dependências do projeto:

    ```bash
    make install
    ```

## Rotas da Aplicação

Abaixo estão as rotas disponíveis na aplicação e suas respectivas funcionalidades:

### 1. Manipulação de Strings Avançada
- **Controller**: `/src/Controller/WordController.php`
- **Chamada**: Está sendo chamada de forma estática no `/src/public/index.php`
- **Rota**:
  - `GET /unique` - Retorna um resultado único de manipulação de strings.

### 2. Integração com Banco de Dados
- **Controller**: `/src/Controller/ProdutoController.php`
- **Rotas**:
  - `GET /produto` - Retorna todos os itens.
  - `GET /produto?item=` - Retorna todos os itens cujo nome contém o valor do parâmetro `item`.
  - `GET /produto?page=&limit=` - Retorna os itens de forma paginada.
  - `POST /produto` - Cria um novo item. 
  - `PUT /produto?id=` - Atualiza o item especificado pelo `id`.
  - `DELETE /produto?id=` - Remove o item especificado pelo `id`.

### 3. Sanitização de Entrada
- **Controller**: `/src/Controller/SanitizeController.php`
- **Rotas**:
  - `GET /sanitize?input=&type=` - Retorna a entrada sanitizada com base no tipo especificado.
  - `POST /sanitize` - Requer os parâmetros `input` e `type` para sanitização.
