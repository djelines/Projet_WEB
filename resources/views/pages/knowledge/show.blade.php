<x-app-layout>
    <!-- En-tête de la page -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilan de compétence généré') }}</span>
        </h1>
    </x-slot>

    <!-- Section : Informations générales du bilan -->
    <div class="relative bg-white dark:bg-[--tw-page-bg-dark] shadow-md rounded-xl p-6 mb-8 border-2 border-gray-200">

        <!-- Bandeau de dégradé décoratif en haut de la carte -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 via-purple-400 to-indigo-400 rounded-tl-sm rounded-tr-sm"></div>

        <!-- Titre de la section -->
        <h2 class="text-xl font-semibold text-sky-900 mb-6 mt-2">Informations du bilan</h2>

        <!-- Cartes individuelles pour les détails du bilan -->
        <div class="flex flex-wrap gap-4 text-gray-800 mt-2">
            <!-- Langages évalués -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-red-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Langages</span>
                <p class="text-sm">{{ implode(', ', $assessment->languages ?? []) }}</p>
            </div>

            <!-- Nombre total de questions -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-pink-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Nombre de questions</span>
                <p class="text-sm">{{ $assessment->num_questions }}</p>
            </div>

            <!-- Promo concernée -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-rose-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Promo concernée</span>
                <p class="text-sm">{{ $assessment->cohort->name }}</p>
            </div>
            <!-- Date de création -->
            <div class="flex-1 min-w-[180px] max-w-sm bg-pink-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
                <span class="block text-sm font-semibold text-gray-600">Date de création</span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($assessment->created_at)->format('d/m/Y H:i') }}</p>
            </div>

        </div>

    </div>

    <hr>
    <!-- Section pour l'admin : Voir l'historique des résultats -->
    @can('view-history', $assessment)
    <div class="text-right mt-2 mb-2 ">
        <a href="{{ route('knowledge.history', $assessment->id) }}" class="inline-block bg-blue-600 !text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
            Voir l'historique des résultats
        </a>
    </div>

    @endcan



    <!-- Section : Liste des questions QCM -->
    <div class="bg-white dark:bg-[--tw-page-bg-dark] shadow-md rounded-xl p-6">
        <h2 class="text-xl font-semibold text-sky-900 mb-4">Questions du QCM</h2>
        <!-- Section pour les admins : Liste des questions QCM -->
        @can('view-qcm', $assessment) @if(isset($qcm) && is_array($qcm) && !empty($qcm))
        <div class="space-y-6">
            @foreach($qcm as $index => $question)
            <!-- Carte individuelle de question -->
            <div class="p-4 rounded-lg border border-purple-200 bg-sky-50 dark:bg-[--tw-page-bg-dark]">
                <p class="font-semibold text-gray-800 mb-3">{{ $index + 1 }}. {{ $question['question'] }}</p>
                <ul class="space-y-1 text-gray-700 pl-4">
                    @foreach($question['choices'] as $choiceIndex => $choice)
                    <li><span class="font-medium">{{ $choiceIndex + 1 }}.</span> {{ $choice }}</li>
                    @endforeach
                </ul>
                <div class="mt-4 text-sm text-lime-800 font-semibold">
                    Bonne réponse : <span class="italic">{{ $question['correct_answer'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-600 italic">Aucune question générée.</p>
        @endif @endcan

        <!-- Section pour les étudiants : Répondre au QCM -->
        @can('answer-qcm', $assessment)
        <form action="{{ route('knowledge.submit', $assessment->id) }}" method="POST" class="bg-white dark:bg-[--tw-page-bg-dark] px-6 rounded-md shadow-md mx-auto">
            @csrf @foreach ($qcm as $index => $question)
            <div class="p-4 rounded-lg border border-purple-200 bg-sky-50 dark:bg-[--tw-page-bg-dark] mb-6">
                <p class="font-semibold text-gray-800 mb-3">
                    <strong>Q{{ $index + 1 }} : </strong> {{ $question['question'] }}
                </p>
                <ul class="space-y-2 text-gray-700 pl-4">
                    @foreach ($question['choices'] as $choiceIndex => $choice)
                    <li>
                        <label class="flex items-center gap-3">
                            <input type="radio" name="answers[{{ $index }}]" value="{{ $choice }}" required class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span class="text-sm">{{ $choice }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

            <div class="text-right">
                <button type="submit" class="!bg-indigo-600 hover:!bg-indigo-700 !text-white !px-4 py-2 rounded-md text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                    Soumettre
                </button>
            </div>
        </form>
        @endcan

        <!-- Bouton pour retourner à la page précédente -->
        <div class="mt-8">
            <a href="{{ route('knowledge.index') }}" class="bg-fuchsia-600 hover:bg-fuchsia-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
            ← Revenir
        </a>
        </div>
    </div>
</x-app-layout>