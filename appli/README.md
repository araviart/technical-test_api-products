# Symfony API avec Docker : Product & Category CRUD

## Introduction

Ce projet est une API Symfony avec deux entités principales : **Product** et **Category**, qui permet de gérer des produits et des catégories en mode CRUD (Create, Read, Update, Delete). L'API est déployée via **API Platform**, et tout est encapsulé dans des containers Docker, facilitant l'installation et l'exécution.

L'API expose également une documentation interactive accessible via `/docs`.

## Prérequis

- **Docker** et **Docker Compose** installés sur votre machine.

## Installation

### 1. Cloner le projet

Clonez le dépôt sur votre machine locale :

```bash
git clone https://github.com/EprocFactory/technical-test_api-products.git
cd technical-test_api-products
```

### 2. Lancer le projet avec Docker

Utilisez la commande suivante pour construire et démarrer les services en arrière-plan :

```bash
docker-compose up -d --build
```

Cette commande :
- Construira les images Docker pour les services **php**, **pwa** et **database**.
- Démarrera les containers pour Symfony (backend), le service **PWA** (si utilisé) et la base de données **PostgreSQL**.

### 3. Accéder à l'application

L'API Symfony sera accessible à l'adresse suivante :

```
http://localhost
```

Vous pouvez également modifier le port d'écoute si nécessaire dans le fichier `docker-compose.yml`. Par exemple, pour changer le port HTTP de 80 à 8080, modifiez la section suivante :

```yaml
ports:
  - target: 80
    published: 8080
    protocol: tcp
```

Ensuite, relancez les containers pour appliquer les modifications :

```bash
docker-compose down
docker-compose up -d --build
```

L'application sera alors accessible à :

```
http://localhost:8080
```

### 4. Initialiser la base de données

Une fois que les containers sont en marche, exécutez la commande suivante pour appliquer les migrations et créer les tables dans la base de données :

```bash
docker-compose exec php php bin/console doctrine:migrations:migrate
```

Si vous avez défini des **fixtures** pour peupler la base de données avec des données d'exemple, vous pouvez les charger avec la commande suivante :

```bash
docker-compose exec php php bin/console doctrine:fixtures:load
```

### 5. Documentation API

L'API est documentée via **API Platform**, et la documentation interactive est disponible à l'adresse suivante :

```
http://localhost/docs
```

Cette interface permet de tester directement les endpoints CRUD pour les entités **Product** et **Category**.

### 6. Endpoints CRUD

#### Entité **Product**
- **GET /products** : Récupérer la liste des produits.
- **POST /products** : Créer un nouveau produit.
- **GET /products/{id}** : Récupérer un produit spécifique par son ID.
- **PUT /products/{id}** : Mettre à jour un produit existant.
- **DELETE /products/{id}** : Supprimer un produit.

#### Entité **Category**
- **GET /categories** : Récupérer la liste des catégories.
- **POST /categories** : Créer une nouvelle catégorie.
- **GET /categories/{id}** : Récupérer une catégorie spécifique par son ID.
- **PUT /categories/{id}** : Mettre à jour une catégorie existante.
- **DELETE /categories/{id}** : Supprimer une catégorie.

### Commandes Docker utiles

#### Démarrer le projet

```bash
docker-compose up -d --build
```

#### Arrêter les containers

```bash
docker-compose down
```

#### Accéder au container Symfony (PHP)

Si vous devez exécuter des commandes Symfony ou PHP dans le container, utilisez la commande suivante pour accéder au shell du container :

```bash
docker-compose exec php sh
```
