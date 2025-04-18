# 🚀 Coding Tool Box – Guide d’installation & Présentation

Bienvenue dans **Coding Tool Box**, une plateforme pédagogique tout-en-un conçue pour la **Coding Factory**.  
Ce projet Laravel inclut la gestion des groupes, promotions, étudiants, rétro (Kanban), QCM dynamiques, et bien plus.

---

## 🧩 Modules intégrés

### 🛠️ Vie Commune  
Gérez les responsabilités partagées entre étudiants.

### 🧠 Bilans de Compétence IA  
Évaluez les connaissances en dev grâce à des QCM générés automatiquement.

---

## 📦 Prérequis
![Made with Laravel](https://img.shields.io/badge/Made%20with-Laravel-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=nodedotjs&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel)


Assurez-vous d’avoir les éléments suivants installés :

- PHP ≥ 8.1  
- Composer  
- MySQL  
- Node.js + npm (pour le frontend)  
- Laravel CLI :  
  ```bash
  composer global require laravel/installer
  ```

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/djelines/Projet_WEB.git
cd Projet_WEB
cp .env.example .env
```

### 2. Configuration du fichier `.env`

```dotenv
DB_DATABASE=nom_de_votre_bdd
DB_USERNAME=utilisateur
DB_PASSWORD=motdepasse
```

### 3. Installation des dépendances

```bash
composer install
```

### 4. Nettoyage du cache & optimisation

```bash
php artisan optimize:clear
```

### 5. Génération de la clé d’application

```bash
php artisan key:generate
```

### 6. Lancement des migrations

```bash
php artisan migrate
```

### 7. Remplissage avec des données de test

```bash
php artisan db:seed
```

---

## 💻 Compilation des assets frontend

```bash
npm install
npm run dev
```

---

## 👥 Comptes de test

| Rôle       | Email                         | Mot de passe | Promo  |
|------------|-------------------------------|--------------|--------|
| **Admin**  | admin@codingfactory.com       | 123456       | 1 et 2 |
| Enseignant | teacher@codingfactory.com     | 123456       | 1      |
| Étudiant   | student@codingfactory.com     | 123456       | 1      |
| Étudiant 2 | student2@codingfactory.com    | 123456       | 2      |

---

## ✅ User Stories (toutes implémentées)

### Vie Commune

- [x] Admin : création, modification, suppression de tâches
- [x] Attribution à une ou plusieurs promotions
- [x] Étudiant : pointage et commentaire
- [x] Historique des tâches effectuées

### Bilans de Compétence

- [x] Admin : génération automatique via IA
- [x] Stockage en base de données
- [x] Attribution aux promotions
- [x] Étudiant : accès restreint, réponse unique, notation instantanée

---

## ✨ Fonctionnalités bonus

- 🎨 Thème **Dark mode** (ajusté sur tous les modules)
- 📷 Affichage d'une **image illustrant l'absence de données**
- 🎯 Couleurs dynamiques des tâches selon leur **catégorie**
- ✅ Messages de **succès / erreur** clairs
- 🔢 **Pagination** sur les tâches & bilans
- 🗓️ **Filtres** par date et ID
- 🔍 **Barre de recherche globale**
- 📊 **Historique détaillé** des tâches par étudiant (côté admin)
- 🌍 Encodage **UTF-8 (Europe/France)**
- 🛑 **Confirmation** avant suppression de QCM
- 📝 **Téléchargement** des résultats en format **PDF**
- ⌛ Ajout d'une **pop up** pendant le téléchargement  
- 🐛 **Easter Egg** : disponible à l’adresse [`/easter-egg`](http://127.0.0.1:8000/easter-egg) en local


---

## 🧑‍💻 Auteurs

- 👩‍💻 [Inès Charfi](https://github.com/djelines)
- 👨‍💻 [Thibaud Magniez](https://bitbucket.org/m_thibaud/projet-web-2025)
