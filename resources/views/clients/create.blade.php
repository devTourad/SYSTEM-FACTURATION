@extends('layouts.app')

@section('title', 'Nouveau Client')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Nouveau Client</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control"
                               id="nom" name="nom" value="{{ old('nom') }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control"
                               id="email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control"
                                  id="adresse" name="adresse" rows="3">{{ old('adresse') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
