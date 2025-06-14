/**
 * Gestion des factures - JavaScript
 * Fonctionnalités pour l'ajout dynamique de produits et calculs
 */

class FactureManager {
    constructor() {
        this.productIndex = 0;
        this.existingProducts = [];
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadExistingProducts();
    }

    bindEvents() {
        // Bouton d'ajout de produit
        const addButton = document.getElementById('addProduct');
        if (addButton) {
            addButton.addEventListener('click', () => this.addProductRow());
        }

        // Auto-impression si demandé
        if (window.location.search.includes('auto-print=1')) {
            window.onload = () => window.print();
        }
    }

    loadExistingProducts() {
        // Charger les produits existants depuis une variable globale
        if (typeof window.existingProducts !== 'undefined') {
            this.existingProducts = window.existingProducts;
            this.existingProducts.forEach(product => {
                this.addProductRow(product);
            });
        }

        // Si aucun produit existant, ajouter une ligne vide
        if (this.existingProducts.length === 0) {
            this.addProductRow();
        }
    }

    addProductRow(existingProduct = null) {
        const template = document.getElementById('productRowTemplate');
        const container = document.getElementById('productsContainer');
        
        if (!template || !container) {
            console.error('Template ou container non trouvé');
            return;
        }

        const clone = template.content.cloneNode(true);
        
        // Remplacer INDEX par l'index actuel
        clone.querySelectorAll('[name*="INDEX"]').forEach(element => {
            element.name = element.name.replace('INDEX', this.productIndex);
        });
        
        container.appendChild(clone);
        
        // Ajouter les event listeners
        const newRow = container.lastElementChild;
        this.setupProductRow(newRow);
        
        // Si c'est un produit existant, le sélectionner
        if (existingProduct) {
            const productSelect = newRow.querySelector('.product-select');
            const quantityInput = newRow.querySelector('.quantity-input');
            
            if (productSelect && quantityInput) {
                productSelect.value = existingProduct.id;
                quantityInput.value = existingProduct.pivot ? existingProduct.pivot.quantite : existingProduct.quantite;
                
                // Déclencher le calcul du sous-total
                productSelect.dispatchEvent(new Event('change'));
            }
        }
        
        this.productIndex++;
    }

    setupProductRow(row) {
        const productSelect = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity-input');
        const subtotalInput = row.querySelector('.subtotal');
        const removeButton = row.querySelector('.remove-product');
        
        if (!productSelect || !quantityInput || !subtotalInput || !removeButton) {
            console.error('Éléments de la ligne produit non trouvés');
            return;
        }

        const updateSubtotal = () => {
            const selectedOption = productSelect.selectedOptions[0];
            const price = selectedOption ? parseFloat(selectedOption.dataset.price) : 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const subtotal = price * quantity;
            
            subtotalInput.value = subtotal.toFixed(2) + ' MRU';
            this.updateTotal();
        };
        
        productSelect.addEventListener('change', updateSubtotal);
        quantityInput.addEventListener('input', updateSubtotal);
        
        removeButton.addEventListener('click', () => {
            row.remove();
            this.updateTotal();
        });
    }

    updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(input => {
            const value = parseFloat(input.value.replace(' MRU', '')) || 0;
            total += value;
        });
        
        const totalElement = document.getElementById('totalAmount');
        if (totalElement) {
            totalElement.textContent = total.toFixed(2) + ' MRU';
        }
    }

    // Méthode pour valider le formulaire
    validateForm() {
        const productRows = document.querySelectorAll('.product-row');
        if (productRows.length === 0) {
            alert('Veuillez ajouter au moins un produit à la facture.');
            return false;
        }

        let hasValidProduct = false;
        productRows.forEach(row => {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            
            if (productSelect && quantityInput && 
                productSelect.value && parseInt(quantityInput.value) > 0) {
                hasValidProduct = true;
            }
        });

        if (!hasValidProduct) {
            alert('Veuillez sélectionner au moins un produit avec une quantité valide.');
            return false;
        }

        return true;
    }
}

// Utilitaires pour l'impression
class PrintManager {
    static printInvoice() {
        window.print();
    }

    static openPrintView(url) {
        window.open(url, '_blank');
    }
}

// Utilitaires pour les confirmations
class ConfirmationManager {
    static confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
        return confirm(message);
    }

    static confirmAction(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }
}

// Initialisation automatique
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le gestionnaire de factures si on est sur une page de facture
    if (document.getElementById('factureForm') || document.getElementById('productsContainer')) {
        window.factureManager = new FactureManager();
    }

    // Ajouter la validation au formulaire
    const factureForm = document.getElementById('factureForm');
    if (factureForm && window.factureManager) {
        factureForm.addEventListener('submit', function(e) {
            if (!window.factureManager.validateForm()) {
                e.preventDefault();
            }
        });
    }

    // Gestion des boutons de suppression avec confirmation
    document.querySelectorAll('form[method="POST"]').forEach(form => {
        if (form.querySelector('input[name="_method"][value="DELETE"]')) {
            form.addEventListener('submit', function(e) {
                if (!ConfirmationManager.confirmDelete()) {
                    e.preventDefault();
                }
            });
        }
    });
});

// Exposer les classes globalement
window.FactureManager = FactureManager;
window.PrintManager = PrintManager;
window.ConfirmationManager = ConfirmationManager;
