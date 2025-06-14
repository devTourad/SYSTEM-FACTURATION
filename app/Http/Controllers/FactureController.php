<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
   
    public function index()
    {
        $factures = Facture::with('client')->paginate(3);
        return view('factures.index', compact('factures'));
    }

   
    public function create()
    {
        $clients = Client::orderBy('nom')->get();
        $produits = Produit::orderBy('libelle')->get();
        return view('factures.create', compact('clients', 'produits'));
    }

   
    public function store(Request $request)
    {
        $facture = new Facture();
        $facture->client_id = $request->client_id;
        $facture->date_facture = $request->date_facture;
        $facture->save();

        foreach ($request->produits as $produitData) {
            $facture->produits()->attach($produitData['id'], [
                'quantite' => $produitData['quantite']
            ]);
        }

        return redirect()->route('factures.show', $facture)
                        ->with('success', __('messages.facture_creee'));
    }

    
    public function show(Facture $facture)
    {
        $facture->load(['client', 'produits']);
        return view('factures.show', compact('facture'));
    }

 
    public function edit(Facture $facture)
    {
        $clients = Client::orderBy('nom')->get();
        $produits = Produit::orderBy('libelle')->get();
        $facture->load('produits');
        return view('factures.edit', compact('facture', 'clients', 'produits'));
    }

  
    public function update(Request $request, Facture $facture)
    {
        $facture->client_id = $request->client_id;
        $facture->date_facture = $request->date_facture;
        $facture->save();

        $facture->produits()->detach();
        foreach ($request->produits as $produitData) {
            $facture->produits()->attach($produitData['id'], [
                'quantite' => $produitData['quantite']
            ]);
        }

        return redirect()->route('factures.show', $facture)
                        ->with('success', __('messages.facture_modifiee'));
    }

 
    public function destroy(Facture $facture)
    {
        $facture->delete();

        return redirect()->route('factures.index')
                        ->with('success', __('messages.facture_supprimee'));
    }

  
    public function generatePdf(Facture $facture)
    {
        $facture->load(['client', 'produits']);

        $pdf = Pdf::loadView('factures.pdf', compact('facture'));

        return $pdf->download('facture-' . $facture->numero_facture . '.pdf');
    }

  
    public function print(Facture $facture)
    {
        $facture->load(['client', 'produits']);
        return view('factures.print', compact('facture'));
    }
}
