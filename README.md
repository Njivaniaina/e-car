# e-car - Vente de Voitures à Madagascar

**e-car** est une plateforme e-commerce moderne spécialisée dans la vente de véhicules (neufs et d'occasion) à Madagascar, avec des prix affichés en **Ariary (Ar)**.

## Fonctionnalités

- **Catalogue complet** : Parcourez une large sélection de voitures filtrables par marque, catégorie et état.
- **Détails riches** : Fiches techniques détaillées (année, kilométrage, transmission, carburant, etc.) et galerie d'images.
- **Système de panier** : Ajoutez vos véhicules favoris au panier et passez commande facilement.
- **Espace Client** : Gérez votre profil et suivez l'historique de vos commandes.
- **Administration Puissante** : 
    - Dashboard avec statistiques de ventes et revenus.
    - Gestion complète des véhicules (CRUD).
    - Suivi et mise à jour des statuts de commande.
    - Gestion des marques et catégories.

## Pile Technique

- **Backend** : PHP 8.2+ / Laravel 12
- **Frontend** : Blade Templates & Vanilla CSS (Design Premium Dark Mode)
- **Authentification** : Laravel Breeze
- **Base de données** : SQLite

## Installation

1. **Cloner le projet**
   ```bash
   git clone <repository-url>
   cd e-car
   ```

2. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Installation des dépendances**
   ```bash
   composer install
   npm install
   ```

4. **Base de données**
   *Assurez-vous que l'extension SQLite est activée dans votre php.ini.*
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Lancement**
   ```bash
   npm run build
   php artisan serve
   ```

## Design

Le projet arbore une esthétique "Glassmorphism" avec un mode sombre élégant, optimisé pour une expérience utilisateur fluide et premium.
