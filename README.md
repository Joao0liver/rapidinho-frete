# Rapidinho Frete 🏍️📦

**Rapidinho Frete** é um sistema para gerenciamento de fretes/transporte rápido de encomendas ou pacotes feitas por motoboys.

---

## Índice

- [Visão Geral](#visão-geral)  
- [Funcionalidades](#funcionalidades 📈)  
- [Tecnologias](#tecnologias)
- [Metodologia](#metodologia)
- [Ferramentas](#ferramentas)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Documentação (Primeira Versão) 📚](Documentação/)
- [Licença](LICENSE.txt)

---

## Visão Geral

O Rapidinho Frete tem como objetivo facilitar o agendamento, acompanhamento e gestão de entregas/fretes. Ele permite que usuários cadastrem pedidos, motoboys, gerenciem rotas, status de entrega, etc.  

É ideal para empresas de logística, entregas expressas e marketplaces que necessitam de um sistema simples e eficaz de frete.

⚠️**Importante:** o sistema foi desenvolvido com base em uma demanda de Juiz de Fora - MG. Portanto, está nichado para esse município, mas com possibilidade de expansão para atuação em outras cidades.

---

## Funcionalidades 📈

Algumas funcionalidades presentes no sistema são:

- Cadastro de clientes, administradores e motoboys
- Edição e visualização dos usuários cadastrados
- Criação e gerenciamento de pedidos de frete
- Visualização do histórico de entregas e solicitações (com diferenciação dependendo do perfil)
- Acompanhamento do status de entrega (pendente, em andamento, entregue) 
- Cálculo de custos de frete baseado em distância/dimensões do pacote/peso  
- Dashboard para visualização de métricas financeiras das entregas para administradores
- Autenticação de login para diferentes níveis de perfil (administrador, motoboy e cliente)

---

## Tecnologias 👨‍💻

Este projeto utiliza as seguintes tecnologias:

- Backend: *PHP + JavaScript*  
- Framework web/API: *Bootstrap*  
- Banco de Dados: *MySQL*  
- Frontend: *HTML + CSS (Responsivo) | FREE HTML TEMPLATE LICENSE BY HTML Codex*
- Outras: *Sass, Chart, Owl Carousel, Tempus Dominus, Waypoints*

---

## Metodologia 🔍

A metodologia usada para esse projeto:

- Metodologia de Desenvolvimento FDD (*Feature Driven Development* – Baseado em Funcionalidades *Adaptado)
- Controle de Requisitos
- Versionamento de Software

---

## Ferramentas 🛠️

As ferramentas usadas no desenvolvimento:

- XAMPP (Ambiente de Desenvolvimento Web)
- DBDesigner (Software de Modelagem de Banco de Dados)
- Dia Portable (Software de Diagramação)
- Visual Studio Code (IDE)
- GitHub + Google Drive

---

## Estrutura do Projeto 🗂️

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
