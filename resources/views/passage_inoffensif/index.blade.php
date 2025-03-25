@extends('general.top')

@section('title', 'LISTES DES PASSAGES INOFENSIFS')

@section('content')
<div class="container-fluid px-4">
    <div class="top-menu mb-3">
        <button class="btn btn-success">
            <a class="text-decoration-none text-white" href="{{ route('passage_inoffensifs.create') }}">Insérer un passage ino</a>
        </button>
    </div>

    <h2 class="mb-4 text-center">⛵ Liste des Données de passages inoffensifs</h2>
    <!-- Formulaire d'importation CSV -->
    <div class="card p-3 mb-4">
        <h5>📥 Importer un fichier CSV</h5>
        <form action="{{ route('passage_inoffensifs.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="csv_file" class="form-control" required accept=".csv">
        </div>
        <button type="submit" class="btn btn-primary">Importer</button>
        </form>
    </div>
    {{-- formulaire de filtre --}}
    <div class="card p-3 mb-4 shadow-sm">
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="year">Année :</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="YYYY" 
                           value="{{ request('year') }}">
                </div>
                <div class="col-md-3">
                    <label for="month">Mois :</label>
                    <input type="number" name="month" id="month" class="form-control" placeholder="MM" min="1" max="12" 
                           value="{{ request('month') }}">
                </div>
                <div class="col-md-3">
                    <label for="day">Jour :</label>
                    <input type="number" name="day" id="day" class="form-control" placeholder="DD" min="1" max="31" 
                           value="{{ request('day') }}">
                </div>
                <div class="col-md-3">
                    <label for="start_date">Date de début :</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 mt-2">
                    <label for="end_date">Date de fin :</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" 
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3 mt-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
                <div class="col-md-3 mt-4 d-flex align-items-end">
                    <a href="{{ route('passage_inoffensifs.index') }}" class="btn btn-secondary w-100">Réinitialiser</a>
                </div>
            </div>
        </form>
    </div>
    
    

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Date d'entrée</th>
                    <th>Date de sortie</th>
                    <th>Navire</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($passages as $passage)
                    <tr>
                        <td>{{ $passage->date_entree }}</td>
                        <td>{{ $passage->date_sortie }}</td>
                        <td>{{ $passage->navire }}</td>
                        <td class="text-center">
                            <form action="{{ route('passage_inoffensifs.destroy', $passage->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce passage ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($passages->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Aucun passage inoffensif enregistré.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <style>
        .table {
            border-radius: 5px; /* Arrondi des bords du tableau à 5px */
            overflow: hidden; /* Conserve l'arrondi des coins */
        }
    
        .table thead {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
    
        .table tbody {
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>
</div>
@endsection
