<x-app-layout>
<x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-blue-600">{{ __('Historique des Tâches Terminées') }}</span>
        </h1>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow-lg space-y-6">
            <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">
                Mes tâches terminées
            </h3>

            @forelse($completedTasks as $task)
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-l-4 border-emerald-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-lg font-semibold text-emerald-700">{{ $task->title }}</h4>

                            @if($task->pivot->comment)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 font-medium">💬 Commentaire :</p>
                                    <p class="text-gray-700 italic">{{ $task->pivot->comment }}</p>
                                </div>
                            @else
                                <p class="mt-2 text-gray-400 italic">Aucun commentaire ajouté.</p>
                            @endif

                            <p class="text-xs text-gray-500 mt-2">Terminé le {{ $task->pivot->updated_at->format('d/m/Y à H:i') }}</p>
                        </div>

                        <a href="{{ route('tasks.show', ['task' => $task->id, 'from_history' => true]) }}"
                           class="ml-4 bg-emerald-600 hover:bg-emerald-700 !text-white text-xs font-semibold px-3 py-2 rounded-lg transition transform hover:scale-105">
                            Voir
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Aucune tâche terminée pour le moment.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $completedTasks->links() }}
            </div>

        </div>

        <div class="mt-6 text-left">
            <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        ← Revenir
            </a>
        </div>
    </div>
</x-app-layout>
