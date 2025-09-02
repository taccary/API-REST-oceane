# 📦 site Océane (front-office & back-office) en architecture MVC - révisions

Projet réalisé dans le cadre des AP web en SIO1 SLAM au semestre 2 de l'année scolaire 2024-25.  

---

## 📌 Sommaire

- [📄 Présentation du projet](#📄-présentation-du-projet)
- [🧱 Architecture MVC](#🧱-architecture-mvc)
- [🗂️ Structure du projet](#🗂️-structure-du-projet)
- [🔄 Cycle de traitement d'une requête](#🔄-cycle-de-traitement-dune-requête)
- [📋 Système de Layout](#📋-explication-du-système-de-layout-pour-les-vues-dans-larchitecture-mvc)
- [📂 Détails des routes de l'application](#📂-détails-des-routes-de-lapplication)

---

## 📄 Présentation du projet

Ce projet est un POC d'application web permettant de gérer les traversées de la compagnie Océane. 

## 🧱 Architecture MVC

L'application suit le modèle MVC (Modèle-Vue-Contrôleur).

Chaque couche a un rôle bien défini :

    1. Modèles : gestion des données et interactions avec la base.
    2. Contrôleurs : logique métier et traitement des requêtes.
    3. Vues : affichage dynamique du contenu.

## 🗂️ Structure du projet

**/controleur** :
Contient les fichiers PHP qui gèrent la logique métier.
- **Exemple** : bateau_controleur.php gère les actions liées aux bateaux (ajout, modification, suppression, etc.).

**/modele** :
Contient les fichiers PHP qui interagissent avec la base de données.
- **Exemple** : bateau_modele.php contient les fonctions pour insérer, modifier, supprimer ou récupérer des bateaux.

**/vue** :
Contient les fichiers PHP qui génèrent le HTML affiché à l'utilisateur.
- **Exemple** : layout.php définit la structure HTML commune (header, footer, etc.), et bateau_CRUD_vue.php affiche l'interface de gestion des bateaux.

**/images** :
Contient les images utilisées dans le site, organisées par catégorie (par exemple, ``/bateaux`` pour les images des bateaux).

**/css** :
Contient les fichiers CSS pour le style du site.
- **Exemple** : ``style.css`` contient les styles globaux pour le site.

**configBdd.php** :
Fichier de configuration pour la connexion à la base de données (par exemple, hôte, nom d'utilisateur, mot de passe, nom de la base).

**index.php** :
Point d'entrée principal du site.
Gère le routage en fonction des paramètres de l'URL (?p=...) et appelle les contrôleurs correspondants.

## 🔄 Cycle de traitement d'une requête

```plaintext
Utilisateur → Route → Contrôleur → Modèle → Base de données
                           ↓
                        Vue (HTML)
```

1. **Utilisateur** :
L'utilisateur effectue une action (par exemple, cliquer sur un bouton ou soumettre un formulaire).
Routeur (index.php) :

2. Le **routeur** analyse la requête (paramètre ``?p=...``) et appelle la fonction correspondante dans le contrôleur.

3. **Contrôleur** :
Le contrôleur traite la requête, appelle les fonctions du modèle si nécessaire, et prépare les données pour la vue.
Modèle :

4. **Modèle** :
Le modèle interagit avec la base de données pour récupérer ou modifier les données.

5. **Vue** :
La vue génère le HTML en utilisant les données fournies par le contrôleur et l'affiche à l'utilisateur.

**Exemple** : 
- **Gestion des bateaux (CRUD) - Ajouter un bateau** :
  1. L'utilisateur clique sur le bouton "Ajouter un bateau" dans l'interface de gestion des bateaux.
  2. Une modale s'ouvre (gérée par JavaScript et Bootstrap) contenant un formulaire pour saisir les informations du bateau (nom, niveau PMR, image, etc.).
  3. L'utilisateur remplit le formulaire et le soumet.
  4. Le formulaire est envoyé au contrôleur `bateau_controleur.php` via une requête POST.
  5. Le contrôleur :
     - Valide les données reçues.
     - Déplace l'image uploadée dans le répertoire `/images/bateaux/` à l'aide de la fonction `move_uploaded_file`.
     - Appelle la fonction `insertBateau` dans le modèle `bateau_modele.php` pour insérer les données dans la base de données.
  6. Une fois l'insertion réussie :
     - Un message de succès est enregistré dans la session (`$_SESSION['success']`).
     - L'utilisateur est redirigé vers la liste des bateaux.
  7. Si une erreur survient (par exemple, problème lors de l'upload de l'image ou de l'insertion dans la base de données) :
     - Un message d'erreur est enregistré dans la session (`$_SESSION['error']`).
     - L'utilisateur est redirigé vers la liste des bateaux avec le message d'erreur affiché.

- **Gestion des bateaux (CRUD) - Modifier un bateau** :
  1. L'utilisateur clique sur le bouton "Modifier" dans la liste des bateaux.
  2. Une modale s'ouvre (gérée par JavaScript et AJAX) pour afficher un formulaire pré-rempli avec les informations du bateau sélectionné.
  3. L'utilisateur modifie les informations (par exemple, le nom ou le niveau PMR) et soumet le formulaire.
  4. Le formulaire est envoyé au contrôleur `bateau_controleur.php`, qui appelle la fonction `updateBateau` dans `bateau_modele.php`.
  5. La fonction `updateBateau` met à jour les informations du bateau dans la base de données.
  6. Une fois la modification effectuée, un message de succès est affiché à l'utilisateur, et la liste des bateaux est mise à jour.

- **Gestion des bateaux (CRUD) - Supprimer un bateau** :
  1. L'utilisateur clique sur le bouton "Supprimer" dans la liste des bateaux.
  2. Une confirmation s'affiche (par exemple, dans une modale ou une alerte).
  3. Si l'utilisateur confirme, une requête est envoyée au contrôleur `bateau_controleur.php`.
  4. Le contrôleur appelle la fonction `deleteBateau` dans `bateau_modele.php` pour supprimer le bateau de la base de données.
  5. Avant de supprimer l'entrée dans la base de données, le contrôleur supprime également l'image associée au bateau du répertoire `/images/bateaux`.
  6. Une fois la suppression effectuée, un message de succès est affiché à l'utilisateur, et la liste des bateaux est mise à jour.


## 📋 Explication du système de Layout pour les vues dans l'Architecture MVC

Le projet utilise un système de **layout** pour gérer l'héritage des vues dans l'architecture MVC. Cela permet de centraliser la structure HTML commune (comme le header, le footer, ou les menus) dans un fichier unique, tout en permettant aux vues spécifiques d'injecter leur contenu dans des sections définies.

Le système de layout repose sur un fichier principal appelé `layout.php`, qui définit la structure HTML globale. Les vues spécifiques injectent leur contenu dans ce layout via des variables.

Voici un exemple de fichier `layout.php` qui définit la structure HTML globale :

```php
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?? '' ?>">
    <meta name="keywords" content="<?= $keywords ?? '' ?>">
    <title><?= $title ?? 'Mon Application' ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mon Application</h1>
        <nav>
            <!-- Menu de navigation -->
        </nav>
    </header>

    <main>
        <?= $content ?? '' ?> <!-- Section où le contenu spécifique sera injecté -->
    </main>

    <footer>
        <p>&copy; 2025 Mon Application. Tous droits réservés.</p>
    </footer>
</body>
</html>
```

Les vues spécifiques (par exemple, `bateau_vue.php`) définissent leur contenu et utilisent le layout pour l'afficher.

```php
<?php
// Définir les variables spécifiques à cette vue
$title = "Nos Bateaux";
$keywords = "bateaux, ferries, accessibilité";
$description = "Découvrez notre flotte et les caractéristiques de nos différents ferries.";

// Capturer le contenu spécifique dans une variable
ob_start();
?>
<h1>Nos Bateaux</h1>
<p>Bienvenue à bord ! Découvrez notre flotte et les caractéristiques de nos différents ferries.</p>
<!-- Contenu spécifique -->
<?php
$content = ob_get_clean(); // Stocker le contenu dans une variable
include 'layout.php'; // Inclure le layout
```

Dans ce code on va retrouver 3 parties :

1. **Définition des variables dynamiques** `$title`, `$keywords`, `$description`, et `$content`. Ces variables sont utilisées dans `layout.php` pour personnaliser le contenu.

2. **Injection de contenu** : La fonction `ob_start()` est utilisée pour capturer le contenu HTML spécifique dans une variable (`$content`). Ce contenu est ensuite injecté dans le layout via `<?= $content ?>`.

3. **Inclusion du layout** : Chaque vue inclut le fichier `layout.php` à la fin, ce qui applique la structure HTML commune.



## 📂 Détails des routes de l'application

- **`?p=accueil`**  
    **Description** : Affiche la page d'accueil du site.  
    **Traitement** : Charge la vue `accueil_vue.php`.

- **`?p=404`**
    **Description** : Affiche une page d'erreur 404 si la route demandée n'existe pas.
    **Traitement** : Charge la vue 404_vue.php.

- **`?p=afficheBateau`**  
    **Description** : Affiche la liste des bateaux disponibles.  
    **Traitement** :  
    - Appelle la fonction `afficherBateaux()` dans le contrôleur `bateau_controleur.php`.  
    - Cette fonction récupère les données via le modèle `bateau_modele.php`.  
    - Charge la vue `bateau_vue.php` pour afficher les données.

- **`?p=afficherCRUDBateau`**  
    **Description** : Affiche l'interface de gestion des bateaux (CRUD).  
    **Traitement** :  
    - Appelle la fonction `afficherCRUDBateaux()` dans le contrôleur `bateau_controleur.php`.  
    - Cette fonction récupère les données nécessaires via le modèle `bateau_modele.php`.  
    - Charge la vue `bateau_CRUD_vue.php`.

- **`?p=chargerModaleBateau`**  
    **Description** : Charge dynamiquement une modale pour ajouter, modifier ou supprimer un bateau.  
    **Traitement** :  
    - Appelle la fonction `ChargerModale()` dans le contrôleur `bateau_controleur.php`.  
    - Retourne une vue partielle (HTML) pour remplir la modale.

- **`?p=actionCRUDBateau`**  
    **Description** : Gère les actions CRUD (ajouter, modifier, supprimer) pour les bateaux.  
    **Traitement** :  
    - En fonction de l'action (`add`, `edit`, `delete`), appelle les fonctions correspondantes dans le contrôleur `bateau_controleur.php` :  
        - `ajouterBateau()` : Ajoute un nouveau bateau.  
        - `modifierBateau()` : Modifie un bateau existant.  
        - `supprimerBateau()` : Supprime un bateau et son image associée.

