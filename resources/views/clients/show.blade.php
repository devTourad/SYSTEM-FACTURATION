@extends('layouts.app')

@section('title', 'Détails Client')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-user"></i> Détails du Client</h4>
                <div>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>ID:</strong> {{ $client->id }}
                    </div>
                    <div class="col-md-6">
                        <strong>Nom:</strong> {{ $client->nom }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Email:</strong> {{ $client->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>Créé le:</strong> {{ $client->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <strong>Adresse:</strong><br>
                        {{ $client->adresse }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-file-invoice"></i> Factures</h5>
            </div>
            <div class="card-body">
                @if($client->factures->count() > 0)
                    <div class="list-group">
                        @foreach($client->factures->take(5) as $facture)
                            <a href="{{ route('factures.show', $facture) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $facture->numero_facture }}</h6>
                                    <small>{{ date('d/m/Y', strtotime($facture->date_facture)) }}</small>
                                </div>
                                <p class="mb-1">{{ number_format($facture->montant_total, 2) }} MRU</p>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($client->factures->count() > 5)
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Et {{ $client->factures->count() - 5 }} autres factures...
                            </small>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-file-invoice fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Aucune facture</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
