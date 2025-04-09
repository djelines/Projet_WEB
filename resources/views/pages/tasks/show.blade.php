<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-blue-600">{{ __('Vie Commune') }}</span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="max-w-3xl mx-auto mt-4 !shadow-xl bg-slate-50 rounded-2xl border-6">
        <h1 class="text-2xl font-semibold text-white p-6 items-center text-center bg-gradient-to-r from-indigo-600 via-blue-500 to-teal-400 rounded-tl-2xl rounded-tr-2xl">
            Détails de la Tâche
        </h1>

        <div class="space-y-4 p-8 bg-white rounded-xl shadow-lg">

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-800">Catégorie</label>
                <!-- Category colours-->
                @php
                            $categoryColors = [
                                'Ménage' => 'bg-blue-200',
                                'Rangement' => 'bg-purple-200',
                                'Courses groupées' => 'bg-green-200',
                                'Courses urgentes' => 'bg-green-200',
                                'Vaisselle' => 'bg-cyan-200',
                                'Cuisine' => 'bg-orange-200',
                                'Achats communs' => 'bg-lime-200',
                                'Maintenance' => 'bg-gray-200',
                                'Événement' => 'bg-pink-200',
                                'Invités' => 'bg-rose-200',
                                'Réunions' => 'bg-indigo-200',
                                'Visites des locaux' => 'bg-yellow-200',
                                'Prise en main des stagiaires' => 'bg-red-200',
                                'Autre' => 'bg-neutral-200',
                            ];
                            $color = $categoryColors[$task->category] ?? 'bg-gray-400';
                        @endphp

                        <!-- Category -->
                        <p class="text-sm text-gray-600 mt-4 mb-4">
                        <span class="{{ $color }} text-slate-950 px-2 py-1 rounded-md text-xs border-2 !border-black">
    {{ $task->category }}
</span>


                        </p>

            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-800">Description</label>
                <p class="text-gray-700">{{ $task->description }}</p>
            </div>

            <div class="space-y-2">
                <label class="block text-base font-semibold text-gray-800">Responsable</label>
                <p class="text-gray-700">{{ $task->user->first_name }} {{ $task->user->last_name }}</p>
            </div>

            <hr class="my-6 border-gray-300">

            <!-- Form to mark task as completed -->
            @if(!$fromHistory && !$task->pivot?->comment)
    <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="space-y-4 pt-6">
        @csrf
        @method('PATCH')

        <div class="space-y-2">
            <label for="comment" class="block text-base font-semibold text-gray-800">Ajouter un commentaire</label>
            <textarea name="comment" id="comment" placeholder="Votre commentaire..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                rows="4"></textarea>
        </div>
        @endif
        <div class="flex flex-row items-end justify-end pt-4 border-gray-200 gap-4">
        <a href="{{ $fromHistory ? route('tasks.history') : route('tasks.index') }}"
        class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
        Revenir
    </a>
            @if(!$fromHistory && !$task->pivot?->comment)
            <button type="submit"
                class="!px-4 py-2 !bg-teal-600 !text-white rounded-lg font-semibold text-sm transition duration-300 ease-in-out transform hover:!bg-teal-700 hover:scale-105 uppercase">
                Marquer comme terminée →
            </button>
            @endif
        </div>
    </form>


        </div>
    </div>
    <!-- end: grid -->
</x-app-layout>
