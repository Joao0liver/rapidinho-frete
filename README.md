# Rapidinho Frete 🚚

**Rapidinho Frete** é um sistema/projeto para gerenciamento de fretes/transporte rápido. Este documento apresenta informações para instalação, uso, estrutura, contribuição e licenças.

---

## Índice

- [Visão Geral](#visão-geral)  
- [Funcionalidades](#funcionalidades)  
- [Tecnologias](#tecnologias)  
- [Instalação](#instalação)  
- [Uso](#uso)  
- [Estrutura do Projeto](#estrutura-do-projeto)  
- [Como Contribuir](#como-contribuir)  
- [Roadmap](#roadmap)  
- [Licença](#licença)
- [Documentação](#Documentação/)

---

## Visão Geral

O Rapidinho Frete tem como objetivo facilitar o agendamento, acompanhamento e gestão de entregas/fretes. Ele permite que usuários cadastrem pedidos, motoristas, gerenciem rotas, status de entrega, etc.  

É ideal para empresas de logística, entregas expressas e marketplaces que necessitam de um sistema simples e eficaz de frete.

---

## Funcionalidades

Algumas funcionalidades esperadas/marcantes:

- Cadastro de clientes  
- Cadastro de motoristas/frotas  
- Criação e gerenciamento de pedidos de frete  
- Acompanhamento do status de entrega (ex: pendente, em rota, entregue)  
- Cálculo de custos de frete baseado em distância/volume/peso  
- Dashboard para visualização rápida de métricas de entrega  
- Autenticação/autorização para diferentes perfis (ex: administrador, motorista)  

---

## Tecnologias

Este projeto utiliza (ou pode utilizar) as seguintes tecnologias:

- Backend: *PHP + JavaScript*  
- Framework web/API: *---*  
- Banco de Dados: *MySQL*  
- Frontend: *HTML + CSS (Responsivo)*
- Outras: *---*

---

## Estrutura do Projeto

```
rapidinho-frete/
│
├── adm/                   # Funcionalidades e páginas para administrador
├── backup/                # Backup do bootstrap
├── bkp_blank/             # Modelo vazio
├── cliente/               # Funcionalidades e páginas para cliente
├── forms/                 # Formulários (login e cadastro)
│
├── layout/                # Recursos visuais e estruturais
│   ├── css/               # Arquivos CSS
│   ├── img/               # Imagens do sistema
│   ├── js/                # Scripts JS
│   ├── lib/               # Bibliotecas externas
│   ├── scss/              # Pré-processadores CSS
│   ├── footer.php         # Rodapé geral
│   ├── header.php         # Cabeçalho genérico
│   ├── header_adm.php     # Cabeçalho exclusivo para administrador
│   ├── header_cliente.php # Cabeçalho exclusivo para cliente
│   ├── header_index.php   # Cabeçalho da página inicial
│   ├── header_mtboy.php   # Cabeçalho exclusivo para motoboy
│
├── motoboy/               # Funcionalidades e páginas para motoboys
├── upload/                # Pasta para arquivos enviados pelos usuários
│
├── conexao.php            # Arquivo de conexão com o banco de dados
├── funcoes.php            # Funções usadas no sistema
├── testes.php             # Arquivo para testes
│
├── LICENSE.txt            # Termos de licença do projeto
├── READ-ME.txt            # Instruções básicas ou anotações sobre o projeto
```
