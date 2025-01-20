# Premier pas avec Symfony 7


## Pre-requis

- PHP 8.3 ou supérieur
- Composer
- SGBDR (MySQL, MariaDB, PostgreSQL ou SQLite)
- symfony-cli

## Créer un BDD

Metre à jour le ficher `.env` avec les informations de connexion à la BDD.

Exemple : 

```
DATABASE_URL="mysql://root@127.0.0.1:3307/dailytrip_sf?serverVersion=8.0.33&charset=utf8mb4"
```

Puis dans le terminal, grâce à symfony-cli, créer la BDD :

```bash
# Créer la BDD
symfony console doctrine:database:create
# Raccourci
symfony console d:d:c

# Créer le ficher de migration
symfony console make:migration

# Exécuter les migrations
symfony console doctrine:migrations:migrate
# Raccourci
symfony console d:m:m -n
```

---

## Lancer l'application

```bash
# Lancer l'application
symfony server:start

# ou
symfony serve

# ou sans les logs (non recommandé pour Windows)
symfony server:start -d

# stopper un serveur en cours d'exécution
symfony server:stop
```

---

## Accéder à l'application

http://localhost:8000 ou http://127.0.0.1:8000

Pour travailler en local avec une configuration qui se rapporche au mieux de la production, nous pouvons installer un certificat SSL en local.

```bash
symfony server:ca:install
```

---

## Twig

Twhig est un moteur de template pour symfony. Il permet de coder des vues avec un HTML surpuissant. On dispose de fonctions et de filtres pour faire des calculs et des transformations.

### Syntaxe

La syntaxte est simple et se compose de trois parties :

|Type|Exemple|
|---|---|
|Variables|{{ variable }}|
|Fonctions|{{ fonction(variable) }}|
|Filtres|{{ variable|filtre }}|

Les variables sont des variables PHP, les fonctions sont des fonctions PHP et les filtres sont des filtres PHP.

### base.html.twig

Afin de ne pas répéter le code des vues, il est possible de s'organiser avec des template de base et des composants.

Le fichier base.html.twig contient le code HTML de base, il est utilisé par toutes les vues qui en font l'appel avec `extends 'base.html.twig'`.

### fonction Twig

Quelque foctions très utiles :

|Fonction|Description|Syntaxe|
|---|---|---|
|dump|Affiche les données en format JSON|{{ dump(variable) }}|
|trans|Traduit une chaîne de caractères|{{ 'Chaîne de caractères'|trans }}|
|for|Exécute une boucle|{% for item in variable %}{% endfor %}|
|if|Exécute une condition|{% if variable %}{% endif %}|
|else|Exécute une condition|{% if variable %}{% else %}{% endif %}|
|elseif|Exécute une condition|{% if variable %}{% elseif variable %}{% endif %}|

---

## Controller

Appelé le cerveau de l'application, il est responsable de gérer les requêtes HTTP et de renvoyer les réponses HTTP. Dans le cas où des données dynamiques sont requises, le controlleur se chargera de les demander à une classe de repository (Model) et de les renvoyer à la vue.

### Annotation

Les annotation permettent de mettre en place du contexte et des règles pour le comportement du code.

|Annotation|Description|Syntaxe|
|---|---|---|
|#[Route]|Définit la route pour le contrôleur|#[Route('/path', name: 'name', methods: ['GET', 'POST'])]|
|#[IsGranted]|Définit les droits pour le contrôleur|#[IsGranted('ROLE_USER')]|

---

## Repository

La classe Repository est une classe qui contient des méthodes pour récupérer des données. Elle est fournie par Symfony et est utilisée pour accéder aux données de la base de données. Les échanges liés aux données reposent sur l'ORM Doctrine.

### Transférer des données à une vue

Dans un controller, précisément sur une méthode qui fait un `render`, on peut faire passer des variables à la vue Twig. Ici un exemple pour récupérer toutes les catégories et les passer à la vue `category/index.html.twig`.

```php
$this->render('category/index.html.twig', [
    'categories' => $cr->findAll(), // Récupérer toutes les catégories
]);
```

---

## Translation

Traduire une application avec Symfony est très simple. On a besoin du package `symfony\translation` et de la configuration `config/packages/translation.yaml`.
Voir la [documentation pour plus de détails]('https://symfony.com/doc/current/translation.html).

Dans twig, on peut utiliser la fonction ou le filtre `trans` pour traduire un texte : 

```twig
{{ 'Hi everyone'|trans }}
```

Par la suite, il faudra extraire toutes les traductions dans un fichier de traductions, de préférence utiliser le format YAML pour sa simplicité.

```bash
symfony console translation:extract --force fr --format=yaml
```

Cela va créer un fichier `translations/messages.fr.yaml` qui contient toutes les traductions de l'application. 

Astuce : Utilisez l'IA pour traduire de nombreux messages en français.
