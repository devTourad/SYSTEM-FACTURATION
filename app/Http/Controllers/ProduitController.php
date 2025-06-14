<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
   
    public function index()
    {
        $produits = Produit::orderBy('libelle')->paginate(4);
        return view('produits.index', compact('produits'));
    }


    public function create()
    {
        return view('produits.create');
    }


    public function store(Request $request)
    {
        $produit = new Produit();
        $produit->libelle = $request->libelle;
        $produit->prix_unitaire = $request->prix_unitaire;
        $produit->save();

        return redirect()->route('produits.index')
                        ->with('success', __('messages.produit_cree'));
    }

 
    public function show(Produit $produit)
    {
        return view('produits.show', compact('produit'));
    }

   
    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

 
    public function update(Request $request, Produit $produit)
    {
        $produit->libelle = $request->libelle;
        $produit->prix_unitaire = $request->prix_unitaire;
        $produit->save();

        return redirect()->route('produits.index')
                        ->with('success', __('messages.produit_modifie'));
    }


    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')
                        ->with('success', __('messages.produit_supprime'));
    }
}
