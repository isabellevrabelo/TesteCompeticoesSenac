# Teste

Sistema web de gerenciamento de eventos e inscrições, desenvolvido em PHP com MySQL. A aplicação possui áreas distintas para administradores, organizadores e usuários comuns.

## Funcionalidades

### Autenticação e cadastro
- Cadastro de usuários com senha protegida por `password_hash`.
- Login com validação de senha por `password_verify`.
- Sessões para manter o usuário autenticado.
- Redirecionamento conforme o perfil do usuário.

### Administrador
- Consultar, cadastrar, editar e excluir usuários.
- Consultar, cadastrar, editar e excluir eventos.
- Consultar inscrições e removê-las.

### Organizador
- Consultar usuários.
- Consultar, cadastrar, editar e excluir eventos.
- Consultar inscrições e removê-las.

### Usuário comum
- Consultar eventos disponíveis.
- Inscrever-se em eventos com vagas disponíveis.
- Consultar as próprias inscrições.
- Cancelar uma inscrição.

### Regras de inscrição
- Verifica se o evento existe e possui vagas disponíveis.
- Impede que o mesmo usuário se inscreva em dois eventos na mesma data, conforme a validação implementada no backend.
- Atualiza a quantidade de vagas ao cancelar uma inscrição.
- Impede a exclusão de eventos que ainda possuem inscrições pela rotina de exclusão de eventos.

### Interface
- Layout com Bootstrap.
- Alternância entre tema claro e escuro usando JavaScript e `localStorage`.
- CSS próprio com ajustes responsivos.

## Tecnologias utilizadas

- PHP
- MySQL / MySQLi
- HTML
- CSS
- JavaScript
- Bootstrap
- XAMPP para execução local

## Estrutura do projeto

```text
Teste/
├── admin/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── img/
│   │   └── gerenciamento-de-projetos.png
│   └── js/
│       └── script.js
├── backend/
│   ├── conexao.php
│   ├── functions.php
│   ├── verificar.php
│   ├── salvar.php
│   ├── cadastrarUsuario.php
│   ├── cadastroEvento.php
│   ├── editarEvento.php
│   ├── editarUsuario.php
│   ├── excluirEvento.php
│   ├── excluirInscricao.php
│   ├── excluirMinhaInscricao.php
│   ├── excluirUsuario.php
│   ├── salvarInscricao.php
│   └── sair.php
├── comum/
├── organizador/
├── cadastro.php
├── index.php
└── .gitignore
```

As pastas `admin`, `comum` e `organizador` contêm as páginas específicas de cada perfil.

## Como executar localmente

### 1. Pré-requisitos

Instale o [XAMPP](https://www.apachefriends.org/) e inicie os serviços Apache e MySQL.

### 2. Coloque o projeto no servidor local

Copie a pasta do projeto para o diretório `htdocs`, por exemplo:

```text
C:\xampp\htdocs\teste
```

Alguns redirecionamentos do código utilizam `/teste/index.php`. Para que funcionem sem alterações, mantenha o nome da pasta como `teste`.

### 3. Crie o banco de dados

No phpMyAdmin, crie o banco:

```sql
CREATE DATABASE teste;
```

O código espera as tabelas `usuarios`, `eventos` e `inscricoes`. O arquivo SQL de criação das tabelas não foi incluído entre os arquivos recebidos; portanto, é necessário criar ou importar um esquema compatível antes de utilizar a aplicação.

### 4. Configure a conexão

Confira o arquivo `backend/conexao.php`. A configuração recebida utiliza:

- **Host:** `localhost`
- **Usuário:** `root`
- **Senha:** vazia
- **Banco de dados:** `teste`
- **Porta:** `3306`

Ajuste esses valores conforme seu ambiente MySQL. Não utilize credenciais padrão em produção.

### 5. Acesse a aplicação

Com Apache e MySQL em execução, abra:

```text
http://localhost/teste/
```

A página inicial é o login. O arquivo `cadastro.php` permite cadastrar uma conta comum.

## Segurança e observações

- As senhas são protegidas com `password_hash` e verificadas com `password_verify`.
- O backend utiliza sessões e verifica o tipo de usuário nas páginas restritas.
- Consultas preparadas são utilizadas em operações do banco de dados.
- A aplicação depende de um banco configurado com as tabelas e colunas esperadas pelo código.
- Não publique senhas, credenciais ou arquivos `.env` com informações privadas.
- O `.gitignore` configurado ignora arquivos de log, `.env`, `.vscode/`, `Thumbs.db` e `vendor/`.

## Melhorias futuras

- Adicionar um arquivo SQL com a estrutura das tabelas e dados iniciais de demonstração.
- Documentar testes automatizados e requisitos de cada perfil.
- Revisar as configurações de segurança antes de publicar em produção.

## Autoria

Projeto desenvolvido para prática de desenvolvimento web com PHP e MySQL.
