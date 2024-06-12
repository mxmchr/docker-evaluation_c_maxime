# Projet Docker

Ce projet contient les solutions aux exercices 1.

## Table des Matières

- [Question 1](#question-1)
- [Question 2](#question-2)
- [Question 3](#question-3)
- [Question 4](#question-4)
- [Question 5](#question-5)
- [Question 6](#question-6)
- [Question 7](#question-7)
- [Question 8](#question-8)
- [Question 9](#question-9)
- [Question 10](#question-10)
- [Question 11](#question-11)
- [Question 12](#question-12)
- [Question 13](#question-13)
- [Question 14](#question-14)
- [Question 15](#question-15)
- [Question 16](#question-16)

## Exercice 1

### Question 1
Qu’est-ce qu’un conteneur ?
Un conteneur est un environnement isolé de tous systèmes et personnalisable.

### Question 2
Est-ce que Docker a inventé les conteneurs Linux ? Qu’a apporté Docker à cette technologie ?
Docker n'a pas inventé les conteneurs ; ils existaient déjà sous le nom de jail. Docker apporte surtout une meilleure accessibilité et une facilité d'utilisation.

### Question 3
Pourquoi est-ce que Docker est particulièrement pensé et adapté pour la conteneurisation de processus sans états (fichiers, base de données, etc.) ?
Docker est particulièrement pensé et adapté pour la conteneurisation de processus sans états pour son isolation vis-à-vis des différents environnements, il permet une meilleure gestion du versionnement, ou encore la gestion des dépendances. Cela permet aussi de redéployer les services de façon très simple.

### Question 4
Quel artefact distribue-t-on et déploie-t-on dans le workflow de Docker ? Quelles propriétés désirables doit-il avoir ?
L'artefact que l'on distribue et que l'on déploie dans le workflow de Docker est une image Docker ; elle doit être légère et simple.

### Question 5
Quelle est la différence entre les commandes docker run et docker exec ?
La commande docker run permet de démarrer un conteneur, alors que la commande docker exec permet d'exécuter une commande à l'intérieur de ce conteneur en cours d'exécution.

### Question 6
Peut-on lancer des processus supplémentaires dans un même conteneur docker en cours d’exécution ?
Oui, il est possible de lancer des processus supplémentaires dans un même conteneur Docker en cours d'exécution notamment en utilisant la commande docker exec, ou alors en démarrant le conteneur en mode interactif. L'environnement reste modifiable en temps réel.

### Question 7
Pourquoi est-il fortement recommandé d’utiliser un tag précis d’une image et de ne pas utiliser le tag latest dans un projet Docker ?
Le risque d'utiliser le tag latest est que, dans le cas où l'image est recréée, la dernière version sera alors utilisée pour construire la nouvelle image, ce qui peut poser des problèmes de compatibilité avec d'autres éléments comme un changement de configuration inattendu.

### Question 8
Décrire le résultat de cette commande : docker run -d -p 9001:80 --name my-php -v"$PWD":/var/www/html php:7.2-apache.
Cette commande permet de lancer un conteneur à partir de l'image php:7.2-apache en exposant le port 80 du conteneur sur le port 9001 de la machine hôte. Le nom du conteneur sera my-php, et le répertoire courant de l'hôte sera monté sur /var/www/html dans le conteneur.

### Question 9
Avec quelle commande Docker peut-on arrêter tous les conteneurs ?
On peut utiliser la commande docker stop $(docker ps -aq) pour arrêter tous les conteneurs.

### Question 10
Quelles précautions doit-on prendre pour construire une image afin de la garder de petite taille et faciliter sa reconstruction ? (2 points)
Pour garantir que l'image soit de petite taille et facile à construire, il faut minimiser les couches de notre Dockerfile et mettre les couches qui sont amenées à changer le plus, le plus bas possible. 

### Question 11
Lorsqu’un conteneur s’arrête, tout ce qu’il a pu écrire sur le disque ou en mémoire est perdu. Vrai ou faux ? Pourquoi ?
Vrai, tout ce qui est écrit pendant l'exécution du conteneur est effacé une fois arrêté, sauf dans le cas de l'utilisation de stockage persistant.

### Question 12
Lorsqu’une image est créée, elle ne peut plus être modifiée. Vrai ou faux ?
Vrai, c'est un objet qui est figé ; il est alors nécessaire de le recréer en cas de modification.

### Question 13
Comment peut-on publier et obtenir facilement des images ?
Pour obtenir ou publier des images, il est possible d'utiliser Docker HUB qui est une librairie d'images pour la conteneurisation.

### Question 14
Comment s’appelle l’image de plus petite taille possible ? Que contient-elle ?
L'image la plus petite est scratch ; elle ne contient que le système de fichiers Linux.

### Question 15
Par quel moyen le client Docker communique-t-il avec le serveur dockerd ? Est-il possible de communiquer avec le serveur via le protocole HTTP ? Pourquoi ?
Le client Docker communique avec le serveur Dockerd en CLI, mais également en HTTP en utilisant son API.

### Question 16
Un conteneur doit lancer un processus par défaut que l’on pourra override à l’exécution. Quelle commande faut-il utiliser pour lancer ce processus : CMD ou ENTRYPOINT ?
Dans le cas de l'exécution d'un processus que l'on veut override par la suite, ENTRYPOINT est plus pertinent.
