# Rapport de Projet : Application Data-Center

## 1. Modélisation de la Base de Données

La base de données a été conçue pour gérer efficacement les utilisateurs, les ressources informatiques et les interactions au sein du Data Center. Voici une description des principales entités et de leurs relations, basées sur nos fichiers de migration.

### Tables Principales

*   **users** : Table centrale des utilisateurs (Administrateurs, Responsables, Invités).
    *   Attributs clés : `name`, `email`, `password`, `sub_type` (sous-type d'utilisateur), `avatar`.
*   **roles & permissions** : Système RBAC (Role-Based Access Control) pour gérer les droits d'accès.
    *   Tables pivots : `user_permission` (pour les exceptions ou droits directs).
*   **ressources** : Entité générique représentant tout équipement ou actif du Data Center.
    *   Attributs : `nom`, `type`, `localistation`, `description`, `status`, `manager_id` (lien vers le responsable).
    *   Relations polymorphes ou héritage logique vers des tables spécifiques :
        *   **serveurs** (`ip_address`, `network_config`...)
        *   **machines_virtuelles**
        *   **equipements_reseau**
        *   **baies_stockage**
*   **demandes** : Gestion des requêtes effectuées par les utilisateurs (demande de ressources, interventions).
*   **compte_demandes** : Table spécifique pour gérer les demandes de création de compte provenant de l'extérieur (Espace Invité).
*   **maintenance_periods** : Planification des fenêtres de maintenance pour les ressources.
*   **notifications** : Système de notification interne pour alerter les utilisateurs.
*   **audit_logs** : Traçabilité des actions critiques (sécurité et historique).
*   **messages** : Système de messagerie interne ou de modération, incluant le statut des messages.

---

## 2. Fonctionnalités Implémentées

L'application est divisée en plusieurs modules fonctionnels, accessibles selon le rôle de l'utilisateur.

### Module Authentification & Sécurité
*   **Login / Register / Logout** : Gestion sécurisée des sessions utilisateurs.
*   **Contrôle d'accès** : Middleware pour restreindre l'accès aux pages selon les rôles (Admin, Responsable, Authentifié).
*   **Gestion des Profils** : Mise à jour des informations personnelles et de l'avatar.

### Module Administration (Back-Office)
*   **Tableau de bord (Dashboard)** : Vue d'ensemble des statistiques et des alertes.
*   **Gestion des Utilisateurs** :
    *   Liste des inscrits.
    *   Attribution et modification des rôles.
    *   Activation/Désactivation rapide de comptes.
*   **Gestion Globale des Ressources** :
    *   Ajout, modification et suppression de tout type de ressource.
    *   Gestion des états (En service, En maintenance, Hors service).
*   **Traitement des Demandes** :
    *   Approbation ou refus des demandes de ressources.
    *   Gestion des demandes de création de compte invité.
*   **Logs & Audit** : Consultation des actions effectuées dans le système.

### Module Responsable
*   **Gestion de Parc Dédié** : Le responsable ne gère que les ressources qui lui sont affectées.
*   **Mise à jour d'état** : Capacité de signaler une ressource en maintenance ou de mettre à jour ses détails techniques.
*   **Modération** : Supervision des messages et signalements.

### Module Espace Invité (Front-Office)
*   **Catalogue Public** : Consultation de la liste des ressources disponibles (en lecture seule).
*   **Demande d'Accès** : Formulaire pour solliciter la création d'un compte utilisateur complet.

---

## 3. Choix Technologiques

Le développement de l'application repose sur une stack moderne, robuste et maintenable, privilégiant l'écosystème PHP/Laravel.

*   **Backend : Laravel (Framework PHP)**
    *   **Version** : Compatible Laravel 11/12 (PHP 8.2+).
    *   **Pourquoi ce choix ?** : Laravel offre une structure MVC claire, un ORM puissant (Eloquent) pour la gestion de la base de données, et des fonctionnalités de sécurité natives (CSRF protection, Hashage de mots de passe, Authentification).
*   **Base de Données : MySQL**
    *   SGBD relationnel standard, performant pour gérer les relations complexes entre utilisateurs, rôles et ressources.
*   **Frontend : Blade & CSS Natif**
    *   **Moteur de template** : Blade (natif Laravel) pour le rendu dynamique des vues côté serveur.
    *   **Styles** : CSS Natif (Vanilla CSS) pour une personnalisation complète et maîtrisée de l'interface utilisateur, sans dépendance à un framework CSS lourd. Utilisation de Vite pour la compilation des assets.
*   **Outils de Développement**
    *   **Composer** : Gestionnaire de dépendances PHP.
    *   **NPM/Node.js** : Gestion des dépendances Frontend.
    *   **Git** : Gestion de versions.

---

## 4. Captures d’écran

*(Cette section est réservée pour l'ajout futur des visuels de l'application : Page de connexion, Dashboard Admin, Formulaire d'ajout de ressource, etc.)*
