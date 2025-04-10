<x-app-layout>
    <!-- En-tête de la page -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilan de compétence généré') }}</span>
        </h1>
    </x-slot>

    <!-- Section : Informations générales du bilan -->
    <div class="relative bg-white shadow-md rounded-xl p-6 mb-8 border-2 border-gray-200">
        
        <!-- Bandeau de dégradé décoratif en haut de la carte -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 via-purple-400 to-indigo-400 rounded-tl-sm rounded-tr-sm"></div>

        <!-- Titre de la section -->
        <h2 class="text-xl font-semibold text-sky-900 mb-6 mt-2">Informations du bilan</h2>

        <!-- Cartes individuelles pour les détails du bilan -->
        <div class="flex flex-wrap gap-4 text-gray-800 mt-2">
            <!-- Langages évalués -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-red-50 rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Langages</span>
                <p class="text-sm">{{ implode(', ', $assessment->languages ?? []) }}</p>
            </div>

            <!-- Niveau de difficulté -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-rose-50 border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Niveau</span>
                <p class="text-sm">{{ ucfirst($assessment->difficulty) }}</p>
            </div>

            <!-- Nombre total de questions -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-pink-50 border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Nombre de questions</span>
                <p class="text-sm">{{ $assessment->num_questions }}</p>
            </div>
        </div>
    </div>

    <hr>

    <!-- Section : Liste des questions QCM -->
    <div class="bg-white shadow-md rounded-xl p-6">
        <h2 class="text-xl font-semibold text-sky-900 mb-4">Questions du QCM</h2>

        <!-- Vérification si des questions QCM sont présentes -->
        @if(isset($qcm) && is_array($qcm) && !empty($qcm))
            <div class="space-y-6">
                @foreach($qcm as $index => $question)
                    <!-- Carte individuelle de question -->
                    <div class="p-4 rounded-lg border border-purple-200 bg-sky-50">
                        <!-- Texte de la question -->
                        <p class="font-semibold text-gray-800 mb-3">{{ $index + 1 }}. {{ $question['question'] }}</p>

                        <!-- Liste des choix possibles -->
                        <ul class="space-y-1 text-gray-700 pl-4">
                            @foreach($question['choices'] as $choiceIndex => $choice)
                                <li><span class="font-medium">{{ $choiceIndex + 1 }}.</span> {{ $choice }}</li>
                            @endforeach
                        </ul>

                        <!-- Affichage de la bonne réponse -->
                        <div class="mt-4 text-sm text-lime-800 font-semibold">
                            Bonne réponse : 
                            <span class="italic">
                                {{ $question['correct_answer'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Message si aucun QCM n'a été généré -->
            <p class="text-gray-600 italic">Aucune question générée.</p>
        @endif
    </div>

    <!-- Bouton pour retourner à la page précédente -->
    <div class="mt-8">
        <a href="{{ route('knowledge.index') }}" class="bg-fuchsia-600 hover:bg-fuchsia-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
            ← Revenir
        </a>
    </div>
</x-app-layout>
