# My Cinema

## Introduction
Ce projet consiste à développer un site web pour gérer un cinéma en utilisant HTML5, CSS, JavaScript, PHP et MySQL. Le site permet d'interagir avec une base de données MySQL pour effectuer diverses opérations de gestion de films et d'abonnés.

## Fonctionnalités
Le site permettra d'effectuer les opérations suivantes :
- **Recherche de films** :
  - Par nom.
  - Par genre.
  - Par distributeur.
- **Recherche de membres** :
  - Par nom.
  - Par prénom.
- **Gestion des abonnements** :
  - Ajouter un abonnement.
  - Modifier un abonnement.
  - Supprimer un abonnement.
- **Historique des abonnés** :
  - Afficher l'historique des films vus par un abonné.
  - Ajouter une entrée à l'historique (film vu par le membre aujourd'hui).
- **Gestion des séances de films** :
  - Ajouter une séance pour un film.
  - Rechercher les films par date de projection (ex. : "Quels films passent ce soir ?").

## Prérequis
- PHP >= 7.4
- MySQL

## Installation et Configuration

### 1. Cloner le Répertoire du Projet
```bash
git clone git@github.com:Liilice/Mycinema.git
cd Mycinema
```

### 2. Configurer la Base de Données
1. Créez une base de données MySQL nommer cinema et importez le fichier de la base de données fourni (`cinema.sql`).
2. Configurez les paramètres de connexion à la base de données dans le fichier `database.php`.
   ```php
    $dsn = 'mysql:host=localhost;dbname=cinema';
    $user = '';
    $password = '';
   ```

### 3. Lancer le serveur 
```bash
php -S localhost:8000
```
