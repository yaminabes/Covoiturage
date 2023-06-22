# Covoiturage

Application de covoiturage pour l'UV PR74

## Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre système :
- Docker
- Docker Compose

## Installation

Créez les conteneurs Docker et démarrez l'environnement de développement :

```
docker-compose up -d
```

Installez les dépendances du projet avec Composer :

```
docker-compose exec php composer install
```

Créez la base de données
```
docker-compose exec php php bin/console doctrine:database:create
```

Effectuez les migrations de la base de données :

```
docker-compose exec php php bin/console doctrine:migrations:migrate
```

Accédez à l'application dans votre navigateur à l'adresse suivante :

```
http://localhost:8741
```

Arrêt de l'environnement de développement
Pour arrêter l'environnement de développement, exécutez la commande suivante :

```
docker-compose down
```

Cela arrêtera les conteneurs Docker associés à l'environnement de développement.

NOTE : J'ai suivi le tutoriel https://yoandev.co/un-environnement-de-d%C3%A9veloppement-symfony-5-avec-docker-et-docker-compose/

# Codage
Pour accéder au container afin d'utiliser les commandes symofony
``` 
docker exec -it www_docker_symfony bash
```
acceder au dossier project
```
cd project
```

Pour se connecter à PHPMyAdmin et voir le contenu de la base de données :
http://localhost:8080
user root et pas de mot de passe
