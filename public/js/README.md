# Documentation JavaScript - Système de Facturation

## Structure des fichiers

### `app.js` - Fonctionnalités générales
Contient les classes et utilitaires utilisés dans toute l'application :

#### Classes principales :
- **`AppManager`** : Gestionnaire principal de l'application
  - Configuration des confirmations de suppression
  - Initialisation des tooltips Bootstrap
  - Masquage automatique des alertes
  - Validation des formulaires

- **`NotificationManager`** : Gestion des notifications
  - `show(message, type)` : Affiche une notification
  - `success(message)` : Notification de succès
  - `error(message)` : Notification d'erreur
  - `warning(message)` : Notification d'avertissement
  - `info(message)` : Notification d'information

- **`TableManager`** : Utilitaires pour les tableaux
  - `highlightRow(row)` : Met en surbrillance une ligne
  - `addRowHoverEffects()` : Ajoute des effets de survol

- **`FormManager`** : Gestion des formulaires
  - `resetForm(formId)` : Remet à zéro un formulaire
  - `disableSubmitButton(form)` : Désactive le bouton de soumission
  - `enableSubmitButton(form, text)` : Réactive le bouton de soumission

- **`FormatManager`** : Formatage des données
  - `formatCurrency(amount)` : Formate un montant en euros
  - `formatDate(date)` : Formate une date
  - `formatNumber(number, decimals)` : Formate un nombre

### `factures.js` - Gestion spécifique des factures
Contient les fonctionnalités spécifiques à la gestion des factures :

#### Classes principales :
- **`FactureManager`** : Gestionnaire des factures
  - Ajout dynamique de lignes de produits
  - Calcul automatique des sous-totaux et total
  - Validation des formulaires de facture
  - Gestion des produits existants (mode édition)

- **`PrintManager`** : Gestion de l'impression
  - `printInvoice()` : Lance l'impression
  - `openPrintView(url)` : Ouvre la vue d'impression

- **`ConfirmationManager`** : Gestion des confirmations
  - `confirmDelete(message)` : Confirmation de suppression
  - `confirmAction(message, callback)` : Confirmation d'action

## Utilisation

### Initialisation automatique
Les scripts s'initialisent automatiquement au chargement de la page :

```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation automatique des gestionnaires
});
```

### Configuration des factures
Pour les pages de factures, définir les produits existants :

```javascript
// Dans les vues Blade
window.existingProducts = @json($facture->produits ?? []);
```

### Utilisation des utilitaires

#### Notifications
```javascript
NotificationManager.success('Opération réussie !');
NotificationManager.error('Une erreur est survenue');
```

#### Formatage
```javascript
const prix = FormatManager.formatCurrency(123.45); // "123,45 €"
const date = FormatManager.formatDate('2023-12-25'); // "25/12/2023"
```

#### Gestion des formulaires
```javascript
FormManager.resetForm('monFormulaire');
FormManager.disableSubmitButton(form);
```

## Fonctionnalités automatiques

### Confirmations de suppression
Tous les formulaires avec la classe `.delete-form` auront automatiquement une confirmation de suppression.

### Validation des formulaires
- Validation automatique des emails
- Validation des nombres (pas de valeurs négatives)
- Validation des prix (limites min/max)

### Raccourcis clavier
- **Ctrl+S** : Soumet le formulaire actuel
- **Échap** : Ferme les modales ouvertes

### Effets visuels
- Survol des lignes de tableau
- Animations de fondu pour les alertes
- Effets de transition sur les boutons

## Personnalisation

### Ajouter de nouvelles fonctionnalités
Pour ajouter de nouvelles fonctionnalités, créer une nouvelle classe :

```javascript
class MonGestionnaire {
    constructor() {
        this.init();
    }
    
    init() {
        // Initialisation
    }
}

// Exposer globalement
window.MonGestionnaire = MonGestionnaire;
```

### Modifier les confirmations
Pour personnaliser les messages de confirmation :

```javascript
// Ajouter l'attribut data-confirm
<button data-confirm="Message personnalisé">Supprimer</button>
```

## Dépendances

- **Bootstrap 5.1.3** : Framework CSS/JS
- **Font Awesome 6.0.0** : Icônes
- **Navigateurs modernes** : Support ES6+

## Bonnes pratiques

1. **Séparation des responsabilités** : `app.js` pour le général, `factures.js` pour le spécifique
2. **Classes modulaires** : Chaque fonctionnalité dans sa propre classe
3. **Initialisation automatique** : Pas besoin d'appels manuels
4. **Gestion d'erreurs** : Vérification de l'existence des éléments DOM
5. **Performance** : Utilisation d'event delegation quand possible
