# SellFlow

**SellFlow** é um sistema simples de gestão de vendas desenvolvido para fins de estudo e portfólio.  
O objetivo do projeto é centralizar o controle de produtos, clientes, formas de pagamento e vendas, oferecendo um dashboard intuitivo para acompanhamento de métricas.

---

## ⚙️ Funcionalidades

### 📊 Dashboard
- Card com **total de vendas realizadas**.  
- Card com **total de produtos cadastrados**.  
- Card com **faturamento total acumulado**.  

### 📦 Produtos
- Cadastro de novos produtos.  
- Edição e exclusão de produtos.  
- Listagem completa na mesma página.  

### 👤 Clientes
- Cadastro de clientes (nome, e-mail, telefone).  
- Edição e exclusão de clientes.  
- Gestão centralizada na página de clientes.  

### 💳 Formas de Pagamento
- Cadastro de novas formas de pagamento.  
- Edição e exclusão de formas existentes.  
- Listagem simples e acessível via Navbar.  

### 🛒 Vendas
- Cadastro de nova venda.  
- Seleção de produtos e definição de quantidade.  
- **Cálculo automático de subtotal** com base nos produtos e quantidades.  
- Definição da forma de pagamento.  
- Seleção do cliente responsável pela compra.  
- Definição de quantidade de parcelas e data da primeira parcela.  
- Possibilidade de editar datas das parcelas.  

---

## 🎯 Objetivo
Este projeto tem como objetivo oferecer uma **plataforma prática e intuitiva de vendas**, servindo de exemplo de desenvolvimento fullstack para portfólio, com ênfase em CRUDs organizados, dashboard informativo e usabilidade.


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
