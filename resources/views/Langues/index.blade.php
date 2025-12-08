@extends('layouts.app')

@section('title', 'Gestion des Langues')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-language"></i>
                        Liste des Langues
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('langues.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Nouvelle Langue
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Message de succès -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tableau des langues avec ID pour DataTable -->
                    <table id="languesTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($langues as $langue)
                            <tr>
                                <td>{{ $langue->id_langue }}</td>
                                <td>{{ $langue->nom_langue }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $langue->code_langue }}</span>
                                </td>
                                <td style="width: 220px;">
                                    <!-- Bouton Voir -->
                                    <a href="{{ route('langues.show', $langue) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('langues.edit', $langue) }}" 
                                       class="btn btn-warning btn-sm"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('langues.destroy', $langue) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette langue ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Aucune langue trouvée
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialisation de DataTable avec AJAX
    $('#languesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('langues.datatable') }}",
            "type": "GET"
        },
        "columns": [
            { "data": "id_langue", "name": "id_langue" },
            { "data": "nom_langue", "name": "nom_langue" },
            { "data": "code_langue", "name": "code_langue" },
            { 
                "data": "actions", 
                "name": "actions", 
                "orderable": false, 
                "searchable": false,
                "className": "text-center"
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tous"]],
        "order": [[0, "desc"]],
        "searching": true,
        "paging": true,
        "info": true,
        "responsive": true
    });
});
</script>
@endsection