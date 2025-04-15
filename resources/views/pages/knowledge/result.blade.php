<x-app-layout>
    <!-- En-tête de la page : Bilans de connaissances -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilans de connaissances') }}</span>
        </h1>
    </x-slot>
    
    <div class="container mx-auto mt-10 px-4">
        <!-- Section : Informations générales du bilan -->
    <div class="relative bg-white dark:bg-[--tw-page-bg-dark] shadow-md rounded-xl p-6 border-2 border-gray-200">
        
        <!-- Bandeau de dégradé décoratif en haut de la carte -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 via-purple-400 to-indigo-400 rounded-tl-sm rounded-tr-sm"></div>

        <!-- Titre de la section -->
        <h2 class="text-xl font-semibold text-sky-900 mb-6 mt-2">Résultat de l'évaluation</h2>

        <!-- Cartes individuelles pour les détails du bilan -->
<div class="flex flex-wrap gap-4 text-gray-800 mt-2">
    <!-- Langages évalués -->
    <div class="flex-1 min-w-[180px] max-w-sm bg-red-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
        <span class="block text-sm font-semibold text-gray-600">Langages évalués</span>
        <p class="text-sm">{{ implode(', ', $assessment->languages) }}</p>
    </div>

    <!-- Nombre de bonnes réponses -->
    <div class="flex-1 min-w-[180px] max-w-sm bg-rose-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
        <span class="block text-sm font-semibold text-gray-600">Bonnes réponses</span>
        <p class="text-sm">{{ $score }} sur {{ $assessment->num_questions }}</p>
    </div>

    <!-- Nombre de mauvaises réponses -->
    <div class="flex-1 min-w-[180px] max-w-sm bg-pink-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
        <span class="block text-sm font-semibold text-gray-600">Mauvaises réponses</span>
        <p class="text-sm">{{ $assessment->num_questions - $score }}</p>
    </div>

    <!-- Note finale sur 20 -->
    <div class="flex-1 min-w-[180px] max-w-sm bg-fuchsia-50 dark:bg-[--tw-page-bg-dark] border rounded-md p-3 shadow-sm">
        <span class="block text-sm font-semibold text-gray-600">Note Finale</span>
        <p class="text-sm">{{ number_format(($score / $assessment->num_questions) * 20, 2) }} / 20</p>
    </div>
</div>

    </div>

        <div class="bg-white  dark:bg-[--tw-page-bg-dark] p-6 rounded-md shadow-md mt-3">
            <div class="mt-6">
                <h3 class="font-semibold text-lg text-gray-800">Détails des réponses :</h3>
                <table class="min-w-full bg-white border border-gray-200 rounded-md shadow-md mt-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left text-sm text-sky-600">Question</th>
                            <th class="px-4 py-2 text-left text-sm text-violet-500">Réponse donnée</th>
                            <th class="px-4 py-2 text-left text-sm text-lime-600">Réponse correcte</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($qcm as $index => $question)
                            <tr class="border-t border-gray-200 dark:bg-[--tw-page-bg-dark]">
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $question['question'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $userAnswers[$index] ?? 'Aucune réponse' }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $question['correct_answer'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

                <!-- Actions -->
                <div class="flex justify-center gap-3 mt-2 mb-4 px-6">
                    @can('view', $assessment) @if(auth()->user()->school()->pivot->role === 'student')
                    <!-- Vérification si l'étudiant a déjà répondu au QCM -->
                    @php $alreadyDone = \App\Models\AssessmentResult::where('assessment_id', $assessment->id) ->where('user_id', auth()->id()) ->whereNotNull('score') // Vérifie si un score existe ->exists(); @endphp @if($alreadyDone)
                    <!-- Message "Déjà fait" si l'étudiant a déjà passé le QCM -->
                    <p class="text-green-700 font-semibold">Déjà fait</p>
                    @else
                    <!-- Bouton pour faire le QCM si ce n'est pas fait -->
                    <a href="{{ route('knowledge.show', $assessment->id) }}#qcm-start" class="bg-green-700 hover:bg-green-800 !text-white px-4 py-2 rounded-md text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                Faire le QCM
            </a> @endif @else
                    <!-- Bouton pour l'admin -->
                    <a href="{{ route('knowledge.show', $assessment->id) }}" class="bg-blue-700 hover:bg-blue-800 !text-white px-4 py-2 rounded-md text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
            Voir le QCM
        </a> @endif @endcan @can('delete', $assessment)
                    <form action="{{ route('knowledge.destroy', $assessment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce bilan ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="!bg-red-800 !text-white px-4 py-2 rounded-md hover:!bg-red-900 text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                            Supprimer
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="pt-5 px-4">
            {{ $assessments->links() }}
        </div>
    </div>
</x-app-layout>