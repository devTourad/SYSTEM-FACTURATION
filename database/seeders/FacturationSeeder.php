<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Facture;

class FacturationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer des clients de test
        $clients = [
            [
                'nom' => 'Jean Dupont',
                'email' => 'jean.dupont@email.com',
                'adresse' => '123 Rue de la Paix, 75001 Paris'
            ],
            [
                'nom' => 'Marie Martin',
                'email' => 'marie.martin@email.com',
                'adresse' => '456 Avenue des Champs, 69000 Lyon'
            ],
            [
                'nom' => 'Pierre Durand',
                'email' => 'pierre.durand@email.com',
                'adresse' => '789 Boulevard Saint-Michel, 13000 Marseille'
            ]
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        // Créer des produits de test
        $produits = [
            [
                'libelle' => 'Ordinateur portable',
                'prix_unitaire' => 899.99
            ],
            [
                'libelle' => 'Souris sans fil',
                'prix_unitaire' => 29.99
            ],
            [
                'libelle' => 'Clavier mécanique',
                'prix_unitaire' => 149.99
            ],
            [
                'libelle' => 'Écran 24 pouces',
                'prix_unitaire' => 199.99
            ],
            [
                'libelle' => 'Webcam HD',
                'prix_unitaire' => 79.99
            ]
        ];

        foreach ($produits as $produitData) {
            Produit::create($produitData);
        }

        // Créer quelques factures de test
        $facture1 = Facture::create([
            'client_id' => 1,
            'date_facture' => now()->subDays(5)
        ]);

        $facture1->produits()->attach([
            1 => ['quantite' => 1],
            2 => ['quantite' => 2],
            3 => ['quantite' => 1]
        ]);

        $facture2 = Facture::create([
            'client_id' => 2,
            'date_facture' => now()->subDays(2)
        ]);

        $facture2->produits()->attach([
            4 => ['quantite' => 2],
            5 => ['quantite' => 1]
        ]);
    }
}
