# Serv+Cuscuz: Sistema de Pedidos / Delivery

Projeto acadêmico desenvolvido para a gestão de pequenos negócios (delivery), estruturado sob o padrão de arquitetura MVC (Model-View-Controller). O sistema visa oferecer controle administrativo eficiente e segmentação de acessos, ideal para microempreendedores

## Funcionalidades Principais
* **Controle de Acesso:** Segmentação por níveis de permissão (Administrador, Funcionário e Cliente).
* **Painel Administrativo:** Gestão completa de produtos, categorias e configurações do sistema.
* **Gestão de Produtos:** Cadastro, edição, exclusão e controle de estoque/detalhes.
* **Gerenciamento de Mídia:** Upload e alteração de imagens para o carrossel de destaque.
* **Arquitetura:** Padrão MVC para separação de responsabilidades e organização do código.
* **Pedidos:** O cliente pode fazer o pedido, e o funcionário alter o status, c o cliente acompanhar a atualização.

## Tecnologia Utilizadas
*  PHP, JavaScript.
* Banco de Dados: SQL, MySQL
* Interface:  HTML5, CSS.

## Passo a Passo para Usar o software.
* Na pasta "Serv+cuscuz/db"
* baixe o banco de dados "serv_cuscuz.sql"
* crie um banco dedos com o nome **"Serv+Cuscuz"** e importe a tebela que voçe fez o donwload
* Caso use o "Xamp" como servidor local, importe para o seu banco de dados no phpmyadmin.
* Dê "Start" no Apach e MySQL.
* Depois abra o admin do MySQL, e confira se o banco está ok.
* O caminho padrão é esse **"C:\xampp\htdocs\Serv-Cuscuz\Serv+Cuscuz""**
* Depois abra a pagina home.php, ou o navegador o caminho **C:\xampp\htdocs\Serv-Cuscuz\Serv+Cuscuz\pages\home.php**
* já vem um pré cadastro de cliente, funcionário e administrador.
* O email e senha de todos já forma definidos.
* **Cliente** cliente@gmail.com |  **Senha** @Manter123
* **Funcionário** funcionario@gmail.com | **Senha:** @Manter123
* **Administrador:** administrador@gmail.com | **Senha:** admin
* Caso queira, pode mudar a senha/criar novo perfil do funcionário pelo painel do Administrador.
* E crie um novo Cliente. Só são aceitos CPF verdadeiros


## Status do Projeto
🚧 **Em desenvolvimento**
* Falta finalizar as abas de pagamentos **(Integração com API)**
* Falta concluir o painel do funcionário.
* Finalizar o perfil do cliente, para a troca de senha.
* e configurar o chat para suporte.

  

![Página Home](https://github.com/user-attachments/assets/be5bee77-2c8f-43f4-8451-c6fc271610c8)



Paninel do administrador
![Painel do administrador](https://github.com/user-attachments/assets/4e2cac56-931e-4d77-b13e-2bf306a49ddd)


Paginda de categorias cadastradadas.
![Pagina de categorias cadastradas](https://github.com/user-attachments/assets/18367eb2-1a47-48e0-8129-824d5874318d)


Cadastro de produtos!
![Pagina de produtos cadastrados](https://github.com/user-attachments/assets/5868847f-5fda-48b6-843b-35a9e5abe4d6)


formulario de edição do produto.
![Formulario de edição do produtos](https://github.com/user-attachments/assets/e5f206c5-6517-4a83-b139-a6b2366b9639)


pagina de cadastro ou alteração de imagens do carrossel 
![pagina de cadastro ou alteração de imagens no carroessel](https://github.com/user-attachments/assets/f1246b83-dcac-49ff-b346-1efe6dc510df)

