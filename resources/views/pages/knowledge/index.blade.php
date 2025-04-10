<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Bilans de connaissances') }}
            </span>
        </h1>
    </x-slot>

<div class="container">
    <h1>Liste des Bilans de Compétence</h1>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des bilans de compétence -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Langages évalués</th>
                <th>Nombre de questions</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Exemple de boucle pour afficher les bilans générés -->
            @foreach($assessments as $assessment)
                <tr>
                    <td>{{ $assessment['id'] }}</td>
                    <td>{{ implode(', ', $assessment['languages']) }}</td>
                    <td>{{ $assessment['num_questions'] }}</td>
                    <td>{{ $assessment['created_at'] }}</td>
                    <td>
                        <a href="{{ route('knowledge.show', $assessment['id']) }}" class="btn btn-info btn-sm">Voir</a>
                        <form action="{{ route('knowledge.destroy', $assessment['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Lien vers la page de création -->
    <a href="{{ route('knowledge.create') }}" class="btn btn-primary">Créer un nouveau bilan</a>
</div>


</x-app-layout>
