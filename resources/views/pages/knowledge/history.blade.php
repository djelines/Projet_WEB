<x-app-layout>
    <!-- En-tête de la page : Bilans de connaissances -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilans de connaissances') }}</span>
        </h1>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold text-indigo-800 mb-2">Historique des résultats</h2>
    </div>

    <div class="mt-10 bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-indigo-100 text-gray-800">
            <tr>
                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Élève</th>
                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Score</th>
                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Répondu le</th>
                <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-[--tw-page-bg-dark] divide-y divide-gray-100">
            @forelse ($results as $result)
                <tr class="hover:bg-sky-50 transition duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-800">
                        {{ $result->user->first_name }} {{ $result->user->last_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-indigo-700 font-semibold">
                        {{ $result->score }} / {{ $assessment->num_questions }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                        {{ $result->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('knowledge.result', $result->id) }}"
                           class="inline-block bg-indigo-600 hover:bg-indigo-900 !text-white text-sm font-semibold px-4 py-2 rounded-lg transition duration-300">
                            Voir les réponses
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-6 text-center text-gray-500 italic">
                        <img src="{{ asset('images/uncompletedAssessment.svg') }}" alt="Aucune tâche" class="mx-auto w-1/3 mb-3">
                        Aucun résultat trouvé pour cette évaluation.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


    <div class="mt-8 text-center">
        <a href="{{ route('knowledge.show', $assessment->id) }}"
           class="inline-block bg-pink-600 hover:bg-pink-700 !text-white px-5 py-2.5 text-sm font-semibold rounded-lg shadow-md transition transform hover:scale-105">
            Revenir au QCM
        </a>
    </div>
</div>

</x-app-layout>
