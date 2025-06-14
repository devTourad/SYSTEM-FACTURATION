# 🧾 Système de Facturation

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1+-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Bootstrap-5.1-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" alt="MySQL">
</p>

<p align="center">
  <strong>Application complète de gestion de facturation pour les entreprises mauritaniennes</strong>
</p>

## 📋 À propos du projet

Ce système de facturation est une application web moderne développée avec Laravel, spécialement conçue pour les entreprises mauritaniennes. Elle offre une solution complète pour la gestion des factures, clients et produits avec support multilingue (Français/Arabe) et utilisation de la devise locale MRU (Ouguiya mauritanienne).

### ✨ Fonctionnalités principales

- **🧾 Gestion des factures** : Création, modification, suppression et génération PDF
- **👥 Gestion des clients** : CRUD complet avec historique des factures
- **📦 Gestion des produits** : Catalogue avec prix en MRU
- **🌍 Multilingue** : Support Français et Arabe avec RTL
- **📄 Génération PDF** : Factures professionnelles avec traductions
- **🖨️ Impression** : Interface d'impression optimisée
- **💰 Devise locale** : Utilisation de MRU (Ouguiya mauritanienne)
- **📱 Responsive** : Interface adaptée mobile/tablette/desktop

## 🚀 Installation et Configuration

### Prérequis

Avant d'installer le projet, assurez-vous d'avoir les éléments suivants installés sur votre PC :

- **PHP 8.1 ou supérieur** avec les extensions suivantes :
  - BCMath PHP Extension
  - Ctype PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js et npm** (pour les assets front-end)
- **MySQL 8.0** ou **MariaDB 10.3+**
- **Serveur web** (Apache, Nginx, ou utiliser le serveur intégré de Laravel)

### 📥 Installation étape par étape

#### 1. Cloner le projet

```bash
# Cloner le repository
git clone https://github.com/votre-username/facturation.git

# Aller dans le dossier du projet
cd facturation
```

#### 2. Installer les dépendances PHP

```bash
# Installer les dépendances avec Composer
composer install
```

#### 3. Installer les dépendances JavaScript (optionnel)

```bash
# Installer les dépendances npm
npm install

# Compiler les assets (si nécessaire)
npm run dev
```

#### 4. Configuration de l'environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

#### 5. Configuration de la base de données

Éditez le fichier `.env` et configurez votre base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=facturation
DB_USERNAME=votre_username
DB_PASSWORD=votre_password
```

#### 6. Créer la base de données

```sql
-- Connectez-vous à MySQL et créez la base de données
CREATE DATABASE facturation CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 7. Exécuter les migrations

```bash
# Exécuter les migrations pour créer les tables
php artisan migrate

# (Optionnel) Ajouter des données de test
php artisan db:seed
```

#### 8. Démarrer le serveur de développement

```bash
# Démarrer le serveur Laravel
php artisan serve
```

L'application sera accessible à l'adresse : `http://127.0.0.1:8000`

### ⚙️ Configuration avancée

#### Configuration du PDF (DomPDF)

Le projet utilise DomPDF pour la génération de PDF. La configuration est déjà incluse, mais vous pouvez personnaliser :

```bash
# Publier la configuration DomPDF (optionnel)
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

#### Configuration des langues

Le projet supporte le français et l'arabe. Les fichiers de traduction se trouvent dans :
- `resources/lang/fr/messages.php` (Français)
- `resources/lang/ar/messages.php` (Arabe)

#### Configuration de l'email (optionnel)

Pour les notifications par email, configurez dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 🔧 Commandes utiles

```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recréer la base de données
php artisan migrate:fresh --seed

# Générer des données de test
php artisan db:seed

# Optimiser pour la production
php artisan optimize
```

### 🐛 Résolution des problèmes courants

#### Erreur de permissions

```bash
# Sur Linux/Mac, donner les permissions aux dossiers
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

#### Erreur de clé d'application

```bash
# Régénérer la clé d'application
php artisan key:generate
```

#### Erreur de base de données

1. Vérifiez que MySQL est démarré
2. Vérifiez les paramètres dans `.env`
3. Assurez-vous que la base de données existe

#### Erreur de dépendances

```bash
# Réinstaller les dépendances
composer install --no-dev --optimize-autoloader
```

## 📱 Utilisation de l'application

### Interface utilisateur

1. **Page d'accueil** : Liste des factures avec actions rapides
2. **Gestion des clients** : Ajouter, modifier, supprimer des clients
3. **Gestion des produits** : Catalogue avec prix en MRU
4. **Création de factures** : Interface intuitive avec calcul automatique
5. **Génération PDF** : Factures professionnelles téléchargeables
6. **Changement de langue** : Boutons FR/AR dans la navbar

### Fonctionnalités clés

- **CRUD complet** pour clients, produits et factures
- **Calcul automatique** des totaux et sous-totaux
- **Génération PDF** avec traductions
- **Interface responsive** pour tous les appareils
- **Support RTL** pour l'arabe
- **Devise MRU** (Ouguiya mauritanienne)

## 🏗️ Structure du projet

```
facturation/
├── app/
│   ├── Http/Controllers/     # Contrôleurs
│   ├── Models/              # Modèles Eloquent
│   └── Http/Middleware/     # Middleware personnalisés
├── database/
│   ├── migrations/          # Migrations de base de données
│   └── seeders/            # Données de test
├── resources/
│   ├── views/              # Templates Blade
│   ├── lang/               # Fichiers de traduction
│   └── css/                # Styles CSS
├── public/
│   ├── css/                # CSS compilés
│   └── js/                 # JavaScript
└── routes/
    └── web.php             # Routes web
```

## 🌐 Support multilingue

L'application supporte deux langues :

- **🇫🇷 Français** : Langue par défaut
- **🇸🇦 Arabe** : Avec support RTL complet

### Ajouter une nouvelle langue

1. Créer le fichier de traduction : `resources/lang/[code]/messages.php`
2. Ajouter la langue dans `LanguageController.php`
3. Mettre à jour la navbar dans `app.blade.php`

## 💰 Devise et localisation

- **Devise principale** : MRU (Ouguiya mauritanienne)
- **Format des nombres** : Adapté à la locale
- **Dates** : Format français/arabe selon la langue

## 🔒 Sécurité

- **Validation CSRF** sur tous les formulaires
- **Validation des données** côté serveur
- **Échappement XSS** automatique avec Blade
- **Middleware d'authentification** (si ajouté)

## 📊 Base de données

### Tables principales

- **clients** : Informations des clients
- **produits** : Catalogue des produits
- **factures** : En-têtes des factures
- **facture_produit** : Lignes de factures (pivot)

### Relations

- Client → Factures (1:N)
- Facture → Produits (N:N via pivot)

## 🚀 Déploiement en production

### Serveur web

1. **Apache/Nginx** : Pointer vers le dossier `public/`
2. **PHP-FPM** : Configurer pour PHP 8.1+
3. **MySQL** : Base de données en production

### Optimisations

```bash
# Optimiser pour la production
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Variables d'environnement

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Changelog

### Version 1.0.0
- ✅ CRUD complet pour clients, produits, factures
- ✅ Support multilingue (FR/AR) avec RTL
- ✅ Génération PDF avec traductions
- ✅ Interface responsive moderne
- ✅ Devise MRU (Ouguiya mauritanienne)
- ✅ Navbar et footer modernes

## 📞 Support

Pour toute question ou problème :

- **Email** : contact@facturation.mr
- **Téléphone** : +222 12 34 56 78
- **Adresse** : Nouakchott, Mauritanie

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

<p align="center">
  <strong>Développé par Tourad Dah pour les entreprises mauritaniennes</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Made%20in-Mauritania-green?style=for-the-badge" alt="Made in Mauritania">
</p>
