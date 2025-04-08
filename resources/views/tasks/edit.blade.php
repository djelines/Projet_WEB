<x-app-layout>
    <x-slot name="header">
            <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
                <span class="text-blue-600">{{ __('Dashboard') }}</span>
            </h1>
        </x-slot>

    <div class="max-w-3xl mx-auto mt-4 !shadow-xl bg-slate-50 rounded-2xl border-6">
        <h1 class="text-2xl font-semibold text-white p-6 items-center text-center bg-gradient-to-r from-indigo-600 via-blue-500 to-teal-400 rounded-tl-2xl rounded-tr-2xl ">Modifier la Tâche</h1>

    
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-4 p-8 bg-white rounded-xl shadow-lg">
            @csrf
            @method('PUT')

            <!-- Titre -->
            <div class="space-y-2">
                <label for="title" class="block text-base font-semibold text-gray-800">Titre</label>
                <input type="text" name="title" id="title" 
                    value="{{ $task->title }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                    placeholder="Entrez un titre...">
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="block text-base font-semibold text-gray-800">Description</label>
                <textarea name="description" id="description" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                    placeholder="Ajoutez des détails...">{{ $task->description }}</textarea>
            </div>

            <!-- Catégorie -->
            <div class="space-y-2">
                <label for="category" class="block text-base font-semibold text-gray-800">Catégorie</label>
                <select name="category" id="category" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="Ménage" {{ $task->category == 'Ménage' ? 'selected' : '' }}>Ménage</option>
                    <option value="Rangement" {{ $task->category == 'Rangement' ? 'selected' : '' }}>Rangement</option>
                    <option value="Courses groupées" {{ $task->category == 'Courses groupées' ? 'selected' : '' }}>Courses groupées</option>
                    <option value="Courses urgentes" {{ $task->category == 'Courses urgentes' ? 'selected' : '' }}>Courses urgentes</option>
                    <option value="Vaisselle" {{ $task->category == 'Vaisselle' ? 'selected' : '' }}>Vaisselle</option>
                    <option value="Cuisine" {{ $task->category == 'Cuisine' ? 'selected' : '' }}>Cuisine</option>
                    <option value="Achats communs" {{ $task->category == 'Achats communs' ? 'selected' : '' }}>Achats communs</option>
                    <option value="Maintenance" {{ $task->category == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="Événement" {{ $task->category == 'Événement' ? 'selected' : '' }}>Événement</option>
                    <option value="Invités" {{ $task->category == 'Invités' ? 'selected' : '' }}>Invités</option>
                    <option value="Réunions" {{ $task->category == 'Réunions' ? 'selected' : '' }}>Réunions</option>
                    <option value="Visites des locaux" {{ $task->category == 'Visites des locaux' ? 'selected' : '' }}>Visites des locaux</option>
                    <option value="Prise en main des stagiaires" {{ $task->category == 'Prise en main des stagiaires' ? 'selected' : '' }}>Prise en main des stagiaires</option>
                    <option value="Autre" {{ $task->category == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <!-- Boutons -->
            <div class="flex flex-row items-end justify-end pt-4 border-gray-200 gap-4">
                <!-- Revenir -->
                <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-bold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                    ← Revenir
                </a>

                <!-- Mettre à jour -->
                <button type="submit"
                    class="!px-4 py-2 !bg-teal-600 !text-white rounded-lg font-semibold text-sm transition duration-300 ease-in-out transform hover:!bg-teal-700 hover:scale-105 uppercase">
                    Mettre à jour →
                </button>
                <!-- Boutons -->
  
            </div>
        </form>
    </div>
</x-app-layout>
