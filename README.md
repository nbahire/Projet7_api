# Projet-7_api: BileMo
BileMo est une entreprise offrant toute une sélection de téléphones mobiles haut de gamme.

## Environnement de développement

### Prérequis

    * PHP 8.1
    * Composer
    * Symfony CLI
    * Docker
    * Docker-compose

Pour verifier les prérequis :

 ```bash
    symfony check:requirements
 ```
## Install
### Download or clone the repository

 ```bash
    git clone https://github.com/nbahire/Projet7_api.git
 ```
### Install docker
 ```bash
    docker compose up -d
 ```
### Download dependencies
 ```bash
    composer install
 ```
### Create database

 ```bash
    php bin/console doctrine:database:create
 ```
### Load Fixtures

 ```bash
    php bin/console doctrine:fixtures:load
 ```
