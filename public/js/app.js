/**
 * Application JavaScript principal
 * Fonctionnalités générales pour toute l'application
 */

class AppManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupDeleteConfirmations();
        this.setupTooltips();
        this.setupAlertAutoHide();
        this.setupFormValidation();
    }

    /**
     * Configuration des confirmations de suppression
     */
    setupDeleteConfirmations() {
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const itemType = this.closest('tr') ? 'cet élément' : 'cette entrée';
                if (!confirm(`Êtes-vous sûr de vouloir supprimer ${itemType} ?`)) {
                    e.preventDefault();
                }
            });
        });

        // Pour les boutons de suppression avec data-confirm
        document.querySelectorAll('[data-confirm]').forEach(element => {
            element.addEventListener('click', function(e) {
                const message = this.dataset.confirm || 'Êtes-vous sûr ?';
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });
    }

    /**
     * Configuration des tooltips Bootstrap
     */
    setupTooltips() {
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    /**
     * Masquage automatique des alertes
     */
    setupAlertAutoHide() {
        document.querySelectorAll('.alert:not(.alert-danger)').forEach(alert => {
            setTimeout(() => {
                if (alert && alert.parentNode) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000); // 5 secondes
        });
    }

    /**
     * Validation des formulaires
     */
    setupFormValidation() {
        // Validation des emails
        document.querySelectorAll('input[type="email"]').forEach(input => {
            input.addEventListener('blur', function() {
                this.setCustomValidity('');
                if (this.value && !this.checkValidity()) {
                    this.setCustomValidity('Veuillez entrer une adresse email valide.');
                }
            });
        });

        // Validation des nombres
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value < 0) {
                    this.value = 0;
                }
            });
        });

        // Validation des prix
        document.querySelectorAll('input[name="prix_unitaire"]').forEach(input => {
            input.addEventListener('input', function() {
                const value = parseFloat(this.value);
                if (value < 0) {
                    this.value = 0;
                } else if (value > 999999.99) {
                    this.value = 999999.99;
                }
            });
        });
    }
}

/**
 * Utilitaires pour les notifications
 */
class NotificationManager {
    static show(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        const container = document.querySelector('.container');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto-hide après 5 secondes
            setTimeout(() => {
                if (alertDiv && alertDiv.parentNode) {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }
            }, 5000);
        }
    }

    static success(message) {
        this.show(message, 'success');
    }

    static error(message) {
        this.show(message, 'danger');
    }

    static warning(message) {
        this.show(message, 'warning');
    }

    static info(message) {
        this.show(message, 'info');
    }
}

/**
 * Utilitaires pour les tableaux
 */
class TableManager {
    static highlightRow(row) {
        row.classList.add('table-warning');
        setTimeout(() => {
            row.classList.remove('table-warning');
        }, 2000);
    }

    static addRowHoverEffects() {
        document.querySelectorAll('table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    }
}

/**
 * Utilitaires pour les formulaires
 */
class FormManager {
    static resetForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            // Supprimer les classes de validation
            form.querySelectorAll('.is-invalid, .is-valid').forEach(element => {
                element.classList.remove('is-invalid', 'is-valid');
            });
        }
    }

    static disableSubmitButton(form) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
        }
    }

    static enableSubmitButton(form, originalText = 'Enregistrer') {
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = `<i class="fas fa-save"></i> ${originalText}`;
        }
    }
}

/**
 * Utilitaires pour le formatage
 */
class FormatManager {
    static formatCurrency(amount) {
        return new Intl.NumberFormat('fr-FR', {
            style: 'currency',
            currency: 'EUR'
        }).format(amount);
    }

    static formatDate(date) {
        return new Intl.DateTimeFormat('fr-FR').format(new Date(date));
    }

    static formatNumber(number, decimals = 2) {
        return parseFloat(number).toFixed(decimals);
    }
}

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function() {
    window.appManager = new AppManager();
    TableManager.addRowHoverEffects();
    
    // Ajouter des raccourcis clavier
    document.addEventListener('keydown', function(e) {
        // Ctrl+S pour sauvegarder
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            const submitButton = document.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
        }
        
        // Échap pour fermer les modales
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) {
                    bsModal.hide();
                }
            });
        }
    });
});

// Exposer les classes globalement
window.AppManager = AppManager;
window.NotificationManager = NotificationManager;
window.TableManager = TableManager;
window.FormManager = FormManager;
window.FormatManager = FormatManager;
