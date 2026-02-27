<p align="center"><a href="https://bece.cultura.ce.gov.br/sebp/" target="_blank"><img src="public/images/logo_vila.png" width="400" alt="Logo do SEBPCE"></a></p>

## Sobre

Esse repositório fornece uma aplicação laravel com a finalidade de ajudar no gerenciamento das atividades escolares do Complexo Cultural Vila das Artes.

## Vila das Artes
A Vila das Artes é um equipamento cultural da Prefeitura de Fortaleza, vinculado à Secretaria Municipal da Cultura (Secultfor) e gerido em parceria com o Instituto Cultural Iracema (ICI), por meio de Contrato de Gestão. Sua estrutura administrativa garante eficiência na execução das políticas públicas de cultura, permitindo que o espaço se afirme como um ambiente vivo de formação, criação e difusão das artes em suas múltiplas linguagens.

Inaugurada em 2006, a Vila das Artes é um espaço de formação, pesquisa, produção e fruição artística, que oferece cursos e atividades gratuitas em diversos formatos e voltadas a diferentes públicos.

A Vila das Artes materializa a política pública de formação para as artes delineada pela Secultfor, sendo um dos principais exemplos de gestão participativa na cultura de Fortaleza. Suas ações priorizam o acesso de crianças e jovens oriundos da escola pública, combinando cursos de curta e longa duração com atividades voltadas à reflexão sobre as relações entre arte e cidade.



## Tecnologias

* PHP 8.2^
* Laravel 12
* Filament 3.2
* MySQL 8.0

## Requisitos

* PHP 8.2^
* Docker
* Docker Compose
* Composer



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