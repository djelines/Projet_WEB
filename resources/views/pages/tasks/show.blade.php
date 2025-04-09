<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800">
            Marquer la tâche "{{ $task->title }}" comme terminée
        </h1>
    </x-slot>

    <div class="max-w-lg mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Détails de la tâche</h3>
            
            <p><strong>Catégorie :</strong> {{ $task->category }}</p>
            <p><strong>Description :</strong> {{ $task->description }}</p>
            <p><strong>Responsable :</strong> {{ $task->user->first_name }} {{ $task->user->last_name }}</p>

            <hr class="my-4">

            <!-- Form to mark task as completed -->
            <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <textarea name="comment" placeholder="Ajouter un commentaire" class="w-full p-2 border border-gray-300 rounded-md" rows="4"></textarea>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm w-full">
                    Marquer comme terminée
                </button>
                <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        ← Revenir
                    </a>
            </form>
        </div>
    </div>
</x-app-layout>
