#Exercice 2

## Table des Matières
- [Introduction](#introduction)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Structure du Projet](#structure-du-projet)
- [Réponses aux questions](#réponses-aux-questions)

## Introduction
Ce projet met en place une architecture Docker avec deux services :
- **Database** : un conteneur MySQL qui héberge la base de données.
- **Client** : un serveur web PHP qui affiche une page web avec les données provenant de la base de données.

## Prérequis
Avant de commencer, assurez-vous d'avoir installé les éléments suivants :
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Installation

### 1. Cloner le dépôt
Clonez le dépôt de votre projet sur votre machine locale :
```bash
git clone https://github.com/mxmchr/docker-evaluation_c_maxime
cd ./docker-evaluation_c_maxime/exercice-1
```
## Structure du Projet
/exercice-1
├── client
│   ├── Dockerfile
│   ├── index.php
│   └── ...
├── database
│   ├── Dockerfile
│   └── ...
├── docker-compose.yml
├── .env
└── README.md

## Réponses aux questions
### 1
Pour que l'execution du script soit automatique, il suffit de monter notre fichier init.sql (script) dans le conteneur mysql à l'emplacement ``` /docker-entrypoint-initdb.d/init.sql ```.

Voici le script en question :
```mysql
CREATE DATABASE IF NOT EXISTS docker_doc;
CREATE DATABASE IF NOT EXISTS docker_doc_dev;

USE docker_doc_dev;

CREATE TABLE IF NOT EXISTS article (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32),
    body TEXT
);

INSERT INTO article (id, title, body) VALUES
(1, 'Docker overview', 'Docker is an open platform for developing, shipping, and running applications. Docker enables you to separate your applications from your infrastructure so you can deliver software quickly.'),
(2, 'What is a container?', 'Imagine you’re developing a killer web app that has three main components - a React frontend, a Python API, and a PostgreSQL database. If you wanted');

USE docker_doc;

CREATE TABLE IF NOT EXISTS article (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32),
    body TEXT
);

GRANT ALL PRIVILEGES ON docker_doc.* TO 'db_client'@'%';
GRANT ALL PRIVILEGES ON docker_doc_dev.* TO 'db_client'@'%';
```
Dans ce script, nous créons les deux bases de données, nous créons égalements les tables Article, et nous remplissons la table Article de la base docker_doc_dev avec des données de tests. Enfin, nous ajoutons les droits de ces bases de données à notre utilsateur db_clients depuis n'importe où.

### 2
Pour lancer un shell intéractif, il suffit de lancer la commande :

```bash
docker exec -it database /bin/sh
```

Ue fois cela fait, nous pouvons vérifier la présence de la base de données en se connectant à celle-ci :

```bash
mysql -u db_client -p docker_doc_dev
```

Pour vérifier l'ajout de nos données nous pouvons intéroger la table :

```mysql
select * from article;
```

### 3
Pour réaliser un dum de notre database docker_doc_deva avec docker exec, nous pouvons utiliser la commmande :

```bash
docker exec database sh -c 'exec mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" docker_doc_dev' > ./docker_doc_dev.sql
```
### 4
Ici, nous allons monter un volume ```bash ./data ``` dans notre conteneur à l'emplacement ```bash /var/lib/mysql ```, afin de rendre les données de notre base de données persistante.
Voici la partie dans le fichier compose du service database permettant cela :

```yaml
---
services:
  database:
    image: mysql:8.3
    container_name: database
    volumes:
      - ./data:/var/lib/mysql
...
```

### 5
Voici le fichier Dockerfile sur lequel se base le service client de mon compose :

```Dockerfile
FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libmariadb-dev && \
    docker-php-ext-install pdo_mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
```

Ici, nous importons les instruction contenu dans php:8.2-apache avec ```bash FROM ``` et nous éxecutons en plus l'installation des packet nécessaire à la communicaiton avec notre base de données avec ```bash RUN ``` permettant d'executer des commandes shell.

Voici l'url de la page web :

```bash
http://localhost:8080
```

#### 6
Afin de développer le script php permettant d'afficher les données de la base, nous montons un volume dans le service client afin d'avoir la possibilité de modifier ce script en temps réelle et de pouvoir voir les modifications :

```yaml
client:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: client
    volumes:
      - ./www:/var/www/html
```

Nous mettons les sources dans le dossier ```bash /var/www/html ```

Pour reconstruire l'image seulement si des changements sont détectés, il est possible de lancer la commande :

```bash
docker compose up -d --build
```
### 7

Pour pouvoir jongler entre les deux environnements, nous utiliserons deux fichers .env.
Nous devons ensuite modificer le fichier compose.yml.

Nous faisons deux fichier, un compose.yml contenant les paramètre communs aux deux environnement, et un fichier compose.dev.yml contenant les paramètres supplémentaire pour l'environnement dev seulement :

#### compose.yml
```yml
---
services:
  database:
    image: mysql:8.3
    container_name: database
    volumes:
      - ./data:/var/lib/mysql
      - ./init.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_USER: db_client
      MYSQL_PASSWORD: ${MYSQL_DB_CLIENT_PASSWORD}
    restart: unless-stopped
  client:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: client
    volumes:
      - ./www:/var/www/html
    ports:
      - "8080:80"
    depends_on:
      - database
    environment:
      DB_HOST: database
      DB_USER: db_client
      DB_PASSWORD: ${MYSQL_DB_CLIENT_PASSWORD}
      DB_NAME: ${DATABASE_NAME}
    restart: unless-stopped
...
```

#### compose.dev.yml
```yml
---
services:
  client:
    environment:
      - CLIENT_MESSAGE=${CLIENT_MESSAGE}
```

Voici les commandes permettant de lancer les conteneur dans les environnement prod ou dev :

#### Dev
```bash
docker compose -f compose.yml -f compose.dev.yml --env-file dev.env up -d
```

#### Prod
```bash
docker compose -f compose.yml --env-file prod.env up -d
```

### 8
Mettre les données confidentielles dans les fichiers d'environnement ne sont pas des bonnes pratiques. Les données contenues dans les fichiers d'environnement ne sont aps chiffré et lisible à totue ersonne ayant accès au système. Le mieux est d'utiliser les mécanisme proposé par Docker : Docker secrets.
