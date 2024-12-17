# Projeto Laravel 11.x com Docker e PostgreSQL

## Descrição
Este é um projeto Laravel 11.x que implementa três CRUDs:
- **Livros**
- **Autores**
- **Assuntos**

O projeto inclui funcionalidades de geração de relatórios PDF:
1. **Livros**: Relatório gerado com todos os livros agrupados por autores.
2. **Autores e Assuntos**: Relatório gerado em ações individuais de cada registro em suas respectivas funcionalidades.

## Requisitos
- **Docker** instalado e configurado.
- **Composer** para gerenciamento de dependências.
- **PostgreSQL** para banco de dados.

---

## Instalação e Execução do Projeto

### 1. Clone o repositório
```bash
git clone https://github.com/leovictor33/laravel-livros.git
cd laravel-livros
```

### 2. Configure o ambiente
Copie o arquivo de exemplo `.env` e configure suas credenciais do banco de dados:
```bash
cp .env.example .env
```
Abra o arquivo `.env` e configure as variáveis do PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=<nome-do-banco>
DB_USERNAME=<usuario>
DB_PASSWORD=<senha>
```

### 3. Instale as dependências
Execute o comando a seguir para instalar as dependências via Composer:
```bash
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --user $(id -u):$(id -g) \
  composer install
```

### 4. Suba os containers com Laravel Sail
```bash
./vendor/bin/sail up
```
> O projeto ficará acessível em `http://localhost`.

### 5. Gere a chave da aplicação
```bash
./vendor/bin/sail php artisan key:generate
```

### 6. Execute as migrações
Para construir a estrutura do banco de dados:
```bash
./vendor/bin/sail php artisan migrate
```

### 7. Popule o banco de dados (opcional)
Caso queira adicionar dados iniciais:
```bash
./vendor/bin/sail php artisan db:seed
```

### 8. Refresh popule o banco de dados (opcional)
Caso queira limpar e adicionar dados novamente:
```bash
./vendor/bin/sail php artisan migrate:refresh --seed
```

### 9. Execute os testes (TDD)
Para rodar os testes automatizados, utilize o comando:
```bash
./vendor/bin/sail artisan test
```

---

## Funcionalidades

### CRUDs Implementados
1. **Livros**
    - Gerenciamento de livros.
    - Relatório PDF: Lista todos os livros agrupados por autores.

2. **Autores**
    - Gerenciamento de autores.
    - Relatório PDF: Gerado individualmente por registro.

3. **Assuntos**
    - Gerenciamento de assuntos.
    - Relatório PDF: Gerado individualmente por registro.

---

## Comandos úteis
### Subir o projeto em background
```bash
./vendor/bin/sail up -d
```

### Parar os containers
```bash
./vendor/bin/sail down
```

### Acessar o terminal do container
```bash
./vendor/bin/sail shell
```

---

## Tecnologias Utilizadas
- **Laravel 11.x**
- **Docker + Laravel Sail**
- **PostgreSQL**
- **Composer**
- **Biblioteca wkhtmltopdf** (para geração de relatórios em PDF)

---

## Contato
Caso tenha dúvidas ou sugestões, entre em contato:
- **Nome**: Leonnardo Araújo
- **E-mail**: leovictor33@gmail.com
- **LinkedIn**: [leovictor33](https://www.linkedin.com/in/leovictor33)

---
