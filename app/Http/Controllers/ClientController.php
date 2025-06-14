<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
 
    public function index()
    {
        $clients = Client::withCount('factures')->orderBy('nom')->paginate(3);
        return view('clients.index', compact('clients'));
    }

   
    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $client = new Client();
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->adresse = $request->adresse;
        $client->save();

        return redirect()->route('clients.index')
                        ->with('success', __('messages.client_cree'));
    }

 
    public function show(Client $client)
    {
        $client->load('factures');
        return view('clients.show', compact('client'));
    }


    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->adresse = $request->adresse;
        $client->save();

        return redirect()->route('clients.index')
                        ->with('success', __('messages.client_modifie'));
    }


    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
                        ->with('success', __('messages.client_supprime'));
    }
}
