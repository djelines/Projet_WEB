<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">
            Historique des tâches terminées
        </h1>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Liste des tâches terminées</h3>

            @forelse($completedTasks as $task)
                <div class="border-b py-4">
                    <h4 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h4>
                    <p class="text-sm text-gray-600">Catégorie : {{ $task->category }}</p>
                    <p class="text-sm text-gray-600 mb-2">Responsable : {{ $task->user->first_name }} {{ $task->user->last_name }}</p>
                    <p class="italic text-gray-500">{{ $task->description }}</p>

                    <!-- Display the comment if it exists -->
                    @if($task->pivot->comment)
                        <div class="mt-2">
                            <p class="font-medium">Votre commentaire :</p>
                            <p>{{ $task->pivot->comment }}</p>
                        </div>
                    @else
                        <p class="mt-2 text-gray-400">Aucun commentaire ajouté.</p>
                    @endif

                    <p class="text-xs text-gray-500 mt-2">{{ $task->pivot->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            @empty
                <div class="text-center mt-4">
                    <p class="text-gray-500">Vous n'avez pas encore terminé de tâches.</p>
                </div>
            @endforelse
        </div>
        <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        ← Revenir
                    </a>
    </div>
</x-app-layout>
