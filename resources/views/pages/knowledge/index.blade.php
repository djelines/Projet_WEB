<x-app-layout>
    <!-- En-tête de la page : Bilans de connaissances -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilans de connaissances') }}</span>
        </h1>
    </x-slot>

    <div class="container mx-auto px-4">
        <!-- Titre + bouton alignés -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Liste des Bilans de Compétence</h1>
            @can('create', \App\Models\Assessment::class)
                <a href="{{ route('knowledge.create') }}" class="bg-fuchsia-800 hover:bg-fuchsia-900 px-4 py-2 rounded-lg !text-red-50 text-sm font-bold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                    Créer un nouveau bilan
                </a>
            @endcan
        </div>

        <div class="flex justify-end mb-4 gap-4">
            <a href="{{ route('knowledge.index', ['sort' => $order === 'asc' ? 'desc' : 'asc', 'sort_by' => 'created_at']) }}"
               class="inline-block !bg-pink-500 !text-white text-sm px-4 py-2 rounded-lg shadow hover:scale-105 transform transition duration-300">
                Trier par date
            </a>

            <a href="{{ route('knowledge.index', ['sort' => $order === 'asc' ? 'desc' : 'asc', 'sort_by' => 'id']) }}"
               class="inline-block !bg-teal-500 !text-white text-sm px-4 py-2 rounded-lg shadow hover:scale-105 transform transition duration-300">
                Trier par ID
            </a>
        </div>

        <hr>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 mb-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Affichage d'une image si aucun bilan -->
        @if($assessments->isEmpty())
            <div class="flex flex-col justify-center items-center mt-6">
                <img src="{{ asset('images/noAssessment.svg') }}" alt="Pas de bilans" class="max-w-xs w-1/3">
                <p class="text-gray-500 mt-4">Il n'y a pas encore de QCM créés.</p>
            </div>
        @else
            <!-- Liste des bilans sous forme de cartes -->
            <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-6">
                @foreach($assessments as $assessment)
                    <div class="bg-white border-2 border-gray-200 shadow-md rounded-xl flex flex-col justify-between">
                        <!-- Bandeau coloré -->
                        <div class="w-full h-2 rounded-t bg-gradient-to-r from-pink-500 via-purple-400 to-indigo-400 mb-4"></div>

                        <!-- Contenu -->
                        <h2 class="text-lg font-semibold text-sky-900 text-center">Bilan #{{ $assessment->id }}</h2>

                        <div class="text-gray-700 text-sm bg-gray-100 border space-y-2 py-3 text-center mt-3 mb-3">
                            <p><span class="font-medium text-gray-600">Langages :</span> {{ implode(', ', $assessment->languages) }}</p>
                            <p><span class="font-medium text-gray-600">Questions :</span> {{ $assessment->num_questions }}</p>
                            <p><span class="font-medium text-gray-600">Créé le :</span> {{ $assessment->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-medium text-gray-600">Créé par :</span> {{ $assessment->user ? $assessment->user->first_name : ' ' }} {{ $assessment->user ? $assessment->user->last_name : ' ' }}</p>
                            <p><span class="font-medium text-gray-600">Pour :</span> {{ $assessment->cohort?->name ?? 'Non attribuée' }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-center gap-3 mt-2 mb-4 px-6">
                            @can('view', $assessment)
                                <a href="{{ route('knowledge.show', $assessment->id) }}" class="bg-indigo-800 hover:bg-indigo-900 !text-white px-4 py-2 rounded-md text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                                    Voir le QCM
                                </a>
                            @endcan

                            @can('answer', $assessment)
                                <a href="{{ route('knowledge.show', $assessment->id) }}#qcm-start" class="bg-green-700 hover:bg-green-800 !text-white px-4 py-2 rounded-md text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105">
                                    Faire le QCM
                                </a>
                            @endcan

                            @can('delete', $assessment)
                                <form action="{{ route('knowledge.destroy', $assessment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce bilan ?')">
                                    @csrf
                                    @method('DELETE')
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
