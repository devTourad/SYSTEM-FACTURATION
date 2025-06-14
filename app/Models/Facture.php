<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'factures';

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec les produits via la table pivot
     */
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'facture_produits')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }

    /**
     * Calcul du montant total de la facture
     */
    public function getMontantTotalAttribute()
    {
        return $this->produits->sum(function ($produit) {
            return $produit->prix_unitaire * $produit->pivot->quantite;
        });
    }

    /**
     * Génère un numéro de facture unique
     */
    public function getNumeroFactureAttribute()
    {
        return 'FAC-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
