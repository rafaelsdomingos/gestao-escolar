# Gestão Escolar

## Sobre

Esse repositório fornece uma aplicação laravel com a finalidade de ajudar no gerenciamento de atividades escolares.


## Tecnologias

* PHP 8.2^
* Laravel 12
* Filament 3.2
* MySQL 8.0


## Desenvolvimento

### 1. Configuração do ambiente

Crie o arquivo .env da aplicação:

```
cp .env.example .env
```

Instale as dependências do projeto:

```
composer install
```

Incialize os cotainers com o laravel sail:

```
./vendor/bin/sail up -d
```


Crie a APP_KEY:

```
php artisan key:generate
```

Rode as migrations para criar a estrutura do banco de dados:

```
./vendor/bin/sail artisan migrate
```

Configure o laravel shield:

```
./vendor/bin/sail artisan shield:generate --all
```

Popule o banco de dados com o comando:

```
./vendor/bin/sail artisan db:seed
```

Configure os assets do sistema

```
./vendor/bin/sail npm install
```

Build os assets do sistema

```
./vendor/bin/sail npm run build
```


### 2. Acesso ao sistema

Endereço da aplicação:

```
http://localhost
```

Usuário: admin@example.com

Senha: password

### 3. Links importantes

Documentação do laravel: 

https://laravel.com/docs/12.x/installation


Documentação do filament php:

https://filamentphp.com/
