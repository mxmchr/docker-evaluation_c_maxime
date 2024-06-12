# Projet Docker

Ce projet contient les solutions aux exercices 1 et 2.

## Exercice 1

### Question 1
Qu’est-ce qu’un conteneur ?

### Question 2
Est-ce que Docker a inventé les conteneurs Linux ? Qu’a apporté Docker à cette technologie ?
Docker n'a pas inventé les conteneurs, ils éxistaient déjà avant sous le nom de jail. Docker apporte surtout une meilleure accéssibilité, et une facilité d'utilisation.

### Question 3
Pourquoi est-ce que Docker est particulièrement pensé et adapté pour la conteneurisation de processus sans états (fichiers, base de données, etc.) ?

### Question 4
Quel artefact distribue-t-on et déploie-t-on dans le workflow de Docker ? Quelles propriétés désirables doit-il avoir ?
L'artefact que l'on distribue et que l'on déploie dans le workflow de Docker est une image Docker, elle doit être légère ... 

### Question 5
Quelle est la différence entre les commandes docker run et docker exec ?
La commande docker run permets démarrer un conteneur, alors que la commande docker exec permets d'éxcecuter une commande à l'intérieur de ce conteneur en cours d'execution.

### Question 6
Peut-on lancer des processus supplémentaires dans un même conteneur docker en cours d’exécution ?
Oui, il est possible de lancer des procéssus supplémentaire dans un même conteneur docker en cours d’exécution nottament en utilisant la commande docker exec, ou alors en démarrant le conteneur en mode intéractif. L'environnement reste modifiable en temps réelle.

### Question 7
Pourquoi est-il fortement recommandé d’utiliser un tag précis d’une image et de ne pas utiliser le tag latest dans un projet Docker ?
Le risque d'utiliser le tag latest est dans le cas ou l'image est recréé, la denernière version sera alors utilisé pour construire la nouvelle image, cela peux poser des problème de compatibilité avec d'autre éléments comme un changement de configuration innatendu.

### Question 8
Décrire le résultat de cette commande : docker run -d -p 9001:80 --name my-php -v"$PWD":/var/www/html php:7.2-apache.
Cette commande permet de lancer un conteneur à partir de l'image php:7.2-apache en exposant le port 80 du conteneur sur le port 9001 de la machine hôte. Le nom du conteneur sera my-php, et le répertoire courant de l'hôter sera monté sur /var/www/html dans le conteneur

### Question 9
Avec quelle commande Docker peut-on arrêter tous les conteneurs ?
On peut utiliser la commande docker stop $(docker ps -aq) pour arrêter tous les conteneurs.

### Question 10
Quelles précautions doit-on prendre pour construire une image afin de la garder de petite taille et faciliter sa reconstruction ? (2 points)
Pour garantir que l'image sois de petite taille, et facile à construire, il faut minimiser les couches de notre dockerfile, et mettre les couches qui sont ammenées à changer le plus, le plus bas possible. 

### Question 11
Lorsqu’un conteneur s’arrête, tout ce qu’il a pu écrire sur le disque ou en mémoire est perdu. Vrai ou faux ? Pourquoi ?
vrai, tout ce qui est écrit pendant l'éxecution du conteneur est éffacé une fois arrêté sauf dans le cas de l'utilisation de stockage persistant.

### Question 12
Lorsqu’une image est créée, elle ne peut plus être modifiée. Vrai ou faux ?

### Question 13
Comment peut-on publier et obtenir facilement des images ?

### Question 14
Comment s’appelle l’image de plus petite taille possible ? Que contient-elle ?

### Question 15
Par quel moyen le client Docker communique-t-il avec le serveur dockerd ? Est-il possible de communiquer avec le serveur via le protocole HTTP ? Pourquoi ?

### Question 16
Un conteneur doit lancer un processus par défaut que l’on pourra override à l’exécution. Quelle commande faut-il utiliser pour lancer ce processus : CMD ou ENTRYPOINT ?


## Exercice 2