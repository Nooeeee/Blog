# TP Blog - PHP 

Ce projet est un blog développé en PHP (avec PDO). Il permet la gestion d'articles, de catégories et de commentaires avec un système d'authentification.

## Prérequis et Configuration

1. **Serveur local** : Utilisez WAMP, XAMPP (PHP 8.0 ou supérieur).
2. **Emplacement du projet** :
   ⚠️ **Important :** Clonez ou placez ce dépôt dans le répertoire web de votre serveur (`www` pour Wamp, `htdocs` pour Xampp) et assurez-vous que le dossier se nomme **exactement** `TPBlog`. Les chemins absolus du projet (ex: `/TPBlog/style/style.css`) dépendent de ce nommage.

## Base de données

Un export complet de la base de données avec un jeu de données (articles, commentaires, catégories) est fourni dans le fichier `TP_blog.sql` situé dans le dossier `database`.

**Instructions d'importation :**
1. Ouvrez phpMyAdmin.
2. Créez une nouvelle base de données nommée exactement **`TP_blog`**.
3. Importez le fichier `.sql` fourni.

**Configuration de la connexion (si besoin) :**
La connexion à la base de données est gérée par un Singleton dans le fichier `config/pdo.php`.
Les identifiants par défaut sont ceux standards de WAMP :
- Host : `localhost`
- Database : `TP_blog`
- User : `root`
- Password : ` ` (vide)

Si votre configuration serveur est différente (ex: MAMP sur Mac avec le mot de passe `root`), veuillez modifier la ligne 7 du fichier `config/pdo.php` :
`$connexion = new PDO('mysql:host=localhost;dbname=TP_blog', 'root', '');`

## Comptes de test

Pour faciliter la correction du TP, voici les identifiants déjà présents dans l'export de la base de données :

**Compte Administrateur (Accès complet + gestion des catégories, articles, commentaires) :**
- **Email :** admin@localhost.fr
- **Mot de passe :** admin69IUT;

**Compte Utilisateur classique (Création d'articles et de commentaires) :**
- **Email :** noe@gmail.com
- **Mot de passe :** azerty

## Fonctionnalités implémentées

- **Système de pagination** fonctionnel sur la page d'accueil (5 articles par page).
- **Filtre par auteur** conservé lors de la navigation entre les pages de pagination.
- **Affichage dynamique** (troncature du texte à l'accueil avec lien "Voir la suite").
- **Espace Administrateur** (suppression d'articles et commentaires, gestion des catégories).
- **Sécurité** :
    - Prévention des failles SQL (utilisation exclusive de requêtes préparées `prepare()`).
    - Prévention des failles XSS (utilisation de `htmlspecialchars()` à l'affichage).
    - Gestion sécurisée des mots de passe en BDD (hash).