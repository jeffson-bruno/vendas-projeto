<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Projeto de Vendas Laravel

Este é um projeto de teste desenvolvido em Laravel para gerenciar vendas, clientes, produtos e formas de pagamento. O sistema possui funcionalidades básicas como cadastro, edição, exclusão, geração de PDF, e um dashboard com métricas.

---

## Requisitos

- PHP >= 8.1
- Composer
- MySQL ou outro banco compatível
- Node.js e npm/yarn (para assets)

---

## Como baixar e rodar o projeto

1. Clone o repositório:

2. Instale as dependências PHP:

        composer install

3. Configure o arquivo .env

Copie o arquivo .env.example para .env e ajuste as configurações do banco de dados e outras variáveis conforme seu ambiente.

        cp .env.example .env

4. Gere a Chave da Aplicação

        php artisan key:generate

5. Execute as migrations e seeders

        php artisan migrate --seed

6. Instale dependências JS e compile os assets:

        npm install
        npm run dev

7. Rode o servidor local:

        php artisan serve

<h2>Uso</h2>

<p> Crie seu próprio usuário diretamente pela tela de login, clicando na opção de cadastro. <br>
    
Você poderá gerenciar vendas, produtos, clientes e formas de pagamento pelo painel. <br>
    
Há também geração de PDF para vendas.
</p>
