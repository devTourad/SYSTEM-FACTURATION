@extends('layouts.app')

@section('title', __('messages.clients'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-users"></i> {{ __('messages.clients') }}</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> {{ __('messages.nouveau') }} {{ __('messages.client') }}
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($clients->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('messages.nom') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.adresse') }}</th>
                            <th>{{ __('messages.nb_factures') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->nom }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ Str::limit($client->adresse, 50) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $client->factures_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('clients.show', $client) }}" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clients.edit', $client) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clients.destroy', $client) }}"
                                              method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
                {{ $clients->links() }}
        @else
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>Aucun client trouvé</h5>
                <p class="text-muted">Commencez par ajouter votre premier client.</p>
                <a href="{{ route('clients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter un Client
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
