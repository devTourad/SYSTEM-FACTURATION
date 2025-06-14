<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureProduit extends Model
{
    use HasFactory;

    protected $table = 'facture_produits';

    /**
     * Relation avec la facture
     */
    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    /**
     * Relation avec le produit
     */
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
