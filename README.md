# Crud-Mundo
# Projeto CRUD Mundo

Este projeto é um sistema CRUD (Criar, Ler, Atualizar, Deletar) para gerenciar informações sobre países e suas respectivas cidades. Ele permite adicionar 5 países por continente e 5 cidades por país, utilizando tecnologias como MySQL, PHP, CSS, HTML e React Native (RN) para a interface mobile.

## Tecnologias Utilizadas

- **Backend:**
  - PHP (para manipulação de dados e interações com o banco)
  - MySQL (banco de dados)
- **Frontend Web:**
  - HTML (estrutura da página)
  - CSS (estilo e design)
- **Frontend Mobile:**
  - React Native (para criar uma interface de usuário responsiva)
  
## Funcionalidades

- Adicionar, editar, excluir e listar países.
- Adicionar, editar, excluir e listar cidades por país.
- Exibir uma lista de países por continente, com a opção de visualizar as cidades de cada país.
  
## Estrutura do Banco de Dados

A estrutura do banco de dados é composta por duas tabelas principais:


1. **Países:**
   - `id` (INT, chave primária)
   - `nome` (VARCHAR)
   - `continente_id` (INT, chave estrangeira referenciando a tabela Continentes)

2. **Cidades:**
   - `id` (INT, chave primária)
   - `nome` (VARCHAR)
   - `pais_id` (INT, chave estrangeira referenciando a tabela Países)
