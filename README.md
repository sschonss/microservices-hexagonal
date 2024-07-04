# Arquiteura Hexagonal (Ports and Adapters)

Existem diversas formas de se organizar um projeto, e uma das formas mais conhecidas é a arquitetura hexagonal. A arquitetura hexagonal é uma forma de organizar o projeto de forma que ele seja independente de frameworks, banco de dados, UI, etc. O objetivo é que o projeto seja independente de qualquer tecnologia, e que possa ser facilmente substituído.

Neste projeto, a arquitetura hexagonal foi implementada utilizando a linguagem de programação PHP e o framework Laravel. A ideia é que o projeto seja independente do Laravel, e dessa maneira, usamos somente o Laravel para criar rotas e controladores, e o restante do projeto é independente do Laravel.

---

## Estrutura do projeto

O projeto foi dividido em 3 camadas principais:
    
- Laravel: Toda a infraestrutura do projeto, como rotas, controladores, etc.
- Adapters: Camada responsável por conter os adaptadores de entrada e saída do projeto.
- Core: Camada responsável por conter as regras de negócio do projeto. Dentro do core, iremos trabalhar com Domain Driven Design (DDD).

---

## Adapters

Os adapters são responsáveis por adaptar as entradas e saídas do projeto. Mas o que isso significa? 

Imagine que você tem um projeto que precisa se comunicar com um banco de dados. Se você não utilizar uma camada de adapter, você terá que utilizar o banco de dados diretamente no seu projeto. Isso significa que você terá que utilizar as classes do banco de dados diretamente no seu projeto, e isso fará com que seu projeto fique dependente do banco de dados.

Então um ORM (Object Relational Mapping) é um exemplo de adapter. O ORM é uma camada que adapta a comunicação com o banco de dados, e dessa maneira, o projeto não fica dependente do banco de dados.

Dentro do nosso projeto, temos os seguintes adapters:

- EmailAdapter: Adapter responsável por enviar e-mails.
- RabbitMQAdapter: Adapter responsável por enviar mensagens para o RabbitMQ.

Neles contém as classes que adaptam a comunicação com o serviço de e-mail e com o RabbitMQ.

Tudo isso somente usando PHP sem Laravel, para que o projeto seja independente e possa ser facilmente substituído.

---

## Core

O core é a camada responsável por conter as regras de negócio do projeto. Dentro do core, iremos trabalhar com Domain Driven Design (DDD).

### O que é DDD?

Domain Driven Design é uma forma de organizar o projeto de forma que ele seja separado por domínios. Cada domínio é uma parte do projeto que contém as regras de negócio. Dessa maneira, o projeto fica organizado e fácil de ser mantido.

Dentro do core, temos os seguintes domínios:

- Email: Domínio responsável por emails em geral da aplicação.
- Connections: Domínio responsável por conexões com serviços externos, como RabbitMQ, Redis, etc.

Dentro de cada domínio, teremos as camadas responsáveis por conter as regras de negócio para cada feature.

O mais importante é que o core não depende de nada. Ele é independente de qualquer framework, banco de dados, etc. Dessa maneira, podemos facilmente substituir o Laravel por outro framework, ou o MySQL por outro banco de dados.

O Core se comunica com serviços externos através dos adapters. Dessa maneira, o core não fica dependente de nenhum serviço externo, somente do adapter.

---

## Projeto

O projeto é um exemplo simples de como a arquitetura hexagonal pode ser implementada. O projeto é um sistema de cadastro de usuários, onde o usuário pode se cadastrar e receber um e-mail de boas-vindas.

O projeto foi dividido em 3 serviços:

- Main App: Serviço principal, onde o usuário se cadastra. Nele está a arquitetura hexagonal.
- RabbitMQ: Serviço de mensageria, onde o Main App envia uma mensagem para o RabbitMQ.
- Email App: Serviço de e-mail, onde lê as mensagens do RabbitMQ e envia um e-mail para o usuário.

Dessa maneira, o Main App não fica dependente do RabbitMQ e do serviço de e-mail. Ele somente envia uma mensagem para o RabbitMQ, e o RabbitMQ envia a mensagem para o serviço de e-mail.

---

## Como rodar o projeto

Para rodar o projeto, você precisa ter o Composer, Docker e o Docker Compose instalados na sua máquina.

Após instalar o Docker e o Docker Compose, basta rodar o seguinte comando:

```bash
cd main-app
composer install
./vendor/bin/sail up
```

Após rodar o comando, o projeto estará rodando na porta 80. 

Já podemos criar um usuário através do endpoint `POST /api/user`, passando o seguinte JSON:

```json
{
    "name": "John Doe",
    "email": "john@doe.com",
    "password": "123456"
}
```

Após criar o usuário, será disparado um evento para o RabbitMQ, mas o serviço de e-mail ainda não está rodando. Para rodar o serviço de e-mail, basta rodar o seguinte comando:

```bash
cd email-app
docker-compose up --build --force-recreate
```

Após rodar o comando, o serviço de e-mail estará rodando e irá ler as mensagens do RabbitMQ e enviar um e-mail para o usuário.

---

## Acessar o RabbitMQ

Para acessar o RabbitMQ, basta acessar o seguinte endereço:

```
http://localhost:15672
```

E fazer login com as seguintes credenciais:

```
Username: guest
Password: guest
```

---

## Conclusão

A arquitetura hexagonal é uma forma de organizar o projeto de forma que ele seja independente de qualquer tecnologia. Neste projeto, a arquitetura hexagonal foi implementada utilizando a linguagem de programação PHP e o framework Laravel. A ideia é que o projeto seja independente do Laravel, e dessa maneira, usamos somente o Laravel para criar rotas e controladores, e o restante do projeto é independente do Laravel.

O projeto é um exemplo simples de como a arquitetura hexagonal pode ser implementada. O projeto é um sistema de cadastro de usuários, onde o usuário pode se cadastrar e receber um e-mail de boas-vindas.

Também foi implementado um serviço de mensageria com RabbitMQ e um serviço de e-mail. Dessa maneira, o Main App não fica dependente do RabbitMQ e do serviço de e-mail. Ele somente envia uma mensagem para o RabbitMQ, e o RabbitMQ envia a mensagem para o serviço de e-mail.

Vimos como a mensageria ajuda a desacoplar os serviços, e como a arquitetura hexagonal ajuda a organizar o projeto de forma que ele seja independente de qualquer tecnologia.

---


