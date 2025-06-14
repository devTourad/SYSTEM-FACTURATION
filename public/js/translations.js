/**
 * Gestionnaire de traductions côté client
 */

class TranslationManager {
    constructor() {
        this.currentLocale = document.documentElement.lang || 'fr';
        this.translations = {};
        this.init();
    }

    init() {
        this.loadTranslations();
        this.setupLanguageSwitch();
        this.updateDirection();
    }

    /**
     * Charger les traductions depuis les attributs data
     */
    loadTranslations() {
        const translationElement = document.getElementById('translations-data');
        if (translationElement) {
            try {
                this.translations = JSON.parse(translationElement.textContent);
            } catch (e) {
                console.error('Erreur lors du chargement des traductions:', e);
            }
        }
    }

    /**
     * Obtenir une traduction
     */
    get(key, defaultValue = '') {
        return this.translations[key] || defaultValue;
    }

    /**
     * Configurer le changement de langue
     */
    setupLanguageSwitch() {
        document.querySelectorAll('[data-language]').forEach(link => {
            link.addEventListener('click', (e) => {
                const locale = e.target.dataset.language;
                if (locale) {
                    this.changeLanguage(locale);
                }
            });
        });
    }

    /**
     * Changer la langue
     */
    changeLanguage(locale) {
        // Afficher un indicateur de chargement
        this.showLoadingIndicator();
        
        // Rediriger vers la route de changement de langue
        window.location.href = `/language/${locale}`;
    }

    /**
     * Mettre à jour la direction du texte
     */
    updateDirection() {
        const isRTL = this.currentLocale === 'ar';
        document.documentElement.dir = isRTL ? 'rtl' : 'ltr';
        
        // Ajouter/supprimer la classe RTL
        if (isRTL) {
            document.body.classList.add('rtl');
        } else {
            document.body.classList.remove('rtl');
        }
    }

    /**
     * Afficher un indicateur de chargement
     */
    showLoadingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'language-loading';
        indicator.className = 'position-fixed top-50 start-50 translate-middle';
        indicator.style.zIndex = '9999';
        indicator.innerHTML = `
            <div class="bg-primary text-white p-3 rounded shadow">
                <i class="fas fa-spinner fa-spin me-2"></i>
                ${this.get('changing_language', 'Changement de langue...')}
            </div>
        `;
        
        document.body.appendChild(indicator);
        
        // Supprimer après 3 secondes au cas où
        setTimeout(() => {
            const element = document.getElementById('language-loading');
            if (element) {
                element.remove();
            }
        }, 3000);
    }

    /**
     * Formater les nombres selon la locale
     */
    formatNumber(number, decimals = 2) {
        const localeMap = {
            'fr': 'fr-FR',
            'ar': 'ar-SA'
        };

        const locale = localeMap[this.currentLocale] || 'fr-FR';

        return new Intl.NumberFormat(locale, {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        }).format(number);
    }

    /**
     * Formater les devises selon la locale
     */
    formatCurrency(amount) {
        const localeMap = {
            'fr': 'fr-FR',
            'ar': 'ar-SA'
        };

        const locale = localeMap[this.currentLocale] || 'fr-FR';

        return new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: 'MRU'
        }).format(amount);
    }

    /**
     * Formater les dates selon la locale
     */
    formatDate(date) {
        const localeMap = {
            'fr': 'fr-FR',
            'ar': 'ar-SA'
        };

        const locale = localeMap[this.currentLocale] || 'fr-FR';

        return new Intl.DateTimeFormat(locale).format(new Date(date));
    }

    /**
     * Obtenir les messages de confirmation traduits
     */
    getConfirmationMessages() {
        return {
            deleteClient: this.get('confirmer_suppression_client', 'Êtes-vous sûr de vouloir supprimer ce client ?'),
            deleteProduct: this.get('confirmer_suppression_produit', 'Êtes-vous sûr de vouloir supprimer ce produit ?'),
            deleteInvoice: this.get('confirmer_suppression_facture', 'Êtes-vous sûr de vouloir supprimer cette facture ?')
        };
    }
}

/**
 * Utilitaires pour les traductions
 */
class TranslationUtils {
    static updateConfirmationMessages() {
        const messages = window.translationManager.getConfirmationMessages();
        
        // Mettre à jour les confirmations de suppression
        document.querySelectorAll('.delete-form').forEach(form => {
            const formAction = form.action;
            let message = messages.deleteClient; // Par défaut
            
            if (formAction.includes('/clients/')) {
                message = messages.deleteClient;
            } else if (formAction.includes('/produits/')) {
                message = messages.deleteProduct;
            } else if (formAction.includes('/factures/')) {
                message = messages.deleteInvoice;
            }
            
            form.dataset.confirm = message;
        });
    }

    static updatePlaceholders() {
        const manager = window.translationManager;
        
        // Mettre à jour les placeholders des formulaires
        document.querySelectorAll('input[placeholder], textarea[placeholder], select[placeholder]').forEach(element => {
            const currentPlaceholder = element.placeholder;
            // Ici, vous pourriez avoir une logique pour traduire les placeholders
            // basée sur des clés de traduction
        });
    }
}

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function() {
    window.translationManager = new TranslationManager();
    TranslationUtils.updateConfirmationMessages();
    TranslationUtils.updatePlaceholders();
});

// Exposer les classes globalement
window.TranslationManager = TranslationManager;
window.TranslationUtils = TranslationUtils;
