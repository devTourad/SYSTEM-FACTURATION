@extends('layouts.app')

@section('title', __('messages.nouvelle') . ' ' . __('messages.factures'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-file-invoice"></i> {{ __('messages.nouvelle') }} {{ __('messages.factures') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('factures.store') }}" method="POST" id="factureForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="client_id" class="form-label">{{ __('messages.client') }}</label>
                            <select class="form-select" id="client_id" name="client_id">
                                <option value="">{{ __('messages.selectionner_client') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                        {{ $client->nom }} ({{ $client->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div> 

                        <div class="col-md-6">
                            <label for="date_facture" class="form-label">{{ __('messages.date_facture') }}</label>
                            <input type="date" class="form-control"
                                   id="date_facture" name="date_facture"
                                   value="{{ old('date_facture', date('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ __('messages.produits') }}</h5>
                            <button type="button" class="btn btn-success btn-sm" id="addProduct">
                                <i class="fas fa-plus"></i> {{ __('messages.ajouter_produit') }}
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="productsContainer">
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5>{{ __('messages.total') }}: <span id="totalAmount">0.00 MRU</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('factures.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('messages.retour') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ __('messages.enregistrer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<template id="productRowTemplate">
    <div class="row mb-3 product-row">
        <div class="col-md-5">
            <select class="form-select product-select" name="produits[INDEX][id]">
                <option value="">{{ __('messages.selectionner_produit') }}</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->id }}" data-price="{{ $produit->prix_unitaire }}">
                        {{ $produit->libelle }} ({{ number_format($produit->prix_unitaire, 2) }} MRU)
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control quantity-input"
                   name="produits[INDEX][quantite]" placeholder="{{ __('messages.quantite') }}" min="1">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control subtotal" readonly placeholder="{{ __('messages.sous_total') }}">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-product">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
// Configuration pour la page de création de facture
window.existingProducts = [];
</script>
@endpush
