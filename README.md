# Desafio em PHP com MySQL

Este projeto é um desafio que envolve a criação de uma aplicação PHP utilizando MySQL como banco de dados. O objetivo é demonstrar habilidades de desenvolvimento web, incluindo a utilização de containers Docker para gerenciar o ambiente.

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

## Executando o Docker

1. Navegue até a pasta `docker`:

```bash
cd docker
```

2. Inicie os containers usando o Makefile:

```bash
make up
```

3. Após o início dos containers, instale as dependências do projeto:

```bash
make install
```

# Acessando a Aplicação

Uma vez que os containers estejam em execução, você pode acessar a aplicação através do seu navegador em http://localhost:8080.