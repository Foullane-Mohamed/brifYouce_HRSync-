# HRSync - Human Resource Management System

## 📌 Description
HRSync est un système de gestion des ressources humaines (HRMS) développé avec Laravel 11. Il permet aux entreprises de gérer efficacement leurs employés, départements et hiérarchies tout en offrant une interface intuitive et moderne.

## 🚀 Fonctionnalités principales
- 🔐 **Authentification et gestion des rôles** (Laravel Breeze/Jetstream + Spatie Permissions)
- 🏢 **Gestion des entreprises et utilisateurs**
- 👥 **Gestion des employés avec suivi de carrière** (promotions, augmentations, formations)
- 📂 **Gestion des contrats et documents** (Laravel Media Library)
- 🌐 **Gestion des départements et hiérarchie**
- 📊 **Affichage dynamique de l'organigramme** (Livewire)
- 📥 **Importation/Exportation des données** (Laravel Excel)
- 🔔 **Notifications RH** (Laravel Notifications)

## 🛠️ Technologies utilisées
- **Backend** : Laravel 11
- **Base de données** : MySQL 
- **Frontend** : Blade + Tailwind CSS
- **Packages principaux** :
  - Spatie Laravel Permissions (gestion des rôles et permissions)
  - Laravel Media Library (gestion des fichiers et documents)
  - Laravel Excel (import/export de données)
  - Livewire (composants dynamiques sans rechargement de page)
  - Laravel Notifications (système d’alertes et notifications)

## 📦 Installation
### Prérequis
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL 

### Étapes d’installation
1. **Cloner le projet**
   ```bash
   git clone https://github.com/Foullane-Mohamed/brifYouce_HRSync-.git
   cd hrsync
   ```
2. **Installer les dépendances**
   ```bash
   composer install
   npm install && npm run build
   ```
3. **Configurer l’environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Modifier le fichier `.env` pour configurer la base de données.

4. **Exécuter les migrations et seeders**
   ```bash
   php artisan migrate --seed
   ```
5. **Lancer le serveur**
   ```bash
   php artisan serve
   ```

## 🛡️ Sécurité et bonnes pratiques
- Utilisation de **middleware** pour la gestion des accès.
- Protection contre les injections SQL avec **Eloquent ORM**.
- Implémentation de **Soft Delete** pour éviter la suppression définitive des employés.
- Validation des données via **Form Requests**.

## 🤝 Contribuer
Les contributions sont les bienvenues ! Suivez ces étapes :
1. **Fork** le projet
2. **Créer** une branche (`feature/ma-fonctionnalité`)
3. **Commit** vos changements (`git commit -m 'Ajout d'une nouvelle fonctionnalité'`)
4. **Push** vers la branche (`git push origin feature/ma-fonctionnalité`)
5. **Créer** une pull request

## 📧 Contact
Si vous avez des questions, n’hésitez pas à me contacter :
📩 Email : [mohamefoullane4@gmail.com]
