<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';

    /**
     * Relation avec les factures via la table pivot
     */
    public function factures()
    {
        return $this->belongsToMany(Facture::class, 'facture_produits')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}
