<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-blue-600">{{ __('Vie Commune') }}</span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-2 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="flex justify-between items-center mb-1">
                <h2 class="text-2xl font-semibold text-gray-800">Liste des Tâches</h2>
                <!-- Ajouter une tâche (uniquement si l'utilisateur peut créer une tâche) -->
                @can('create', App\Models\Task::class)
                    <a href="{{ route('tasks.create') }}" class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-red-50 text-sm font-bold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        Ajouter une tâche
                    </a>
                @endcan

            </div>
            <!-- Button for sorting by date (toggle ascending/descending) -->
            <form action="{{ route('tasks.index') }}" method="GET" class="inline flex flex-row items-end justify-end mb-4 gap-4">
                <input type="hidden" name="sort" value="{{ request('sort', 'asc') === 'asc' ? 'desc' : 'asc' }}">
                <button type="submit" class="!bg-blue-500 hover:!bg-blue-700 !text-white px-4 py-2 rounded-lg text-sm transition duration-300 ease-in-out">
                    Trier par date ({{ request('sort', 'asc') === 'asc' ? 'ascendant' : 'descendant' }})
                </button>
                @can('viewHistory', App\Models\Task::class)
                    <a href="{{ route('tasks.history') }}" class="bg-violet-500 hover:bg-violet-700 !text-white px-4 py-2 rounded-lg text-sm transition duration-300 ease-in-out">Voir mon historique</a>
                @endcan

            </form>

            <hr>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Flexbox + wrap to allow elements to return to the line -->
            <div class="flex flex-wrap gap-8 mt-6 justify-center">
                @forelse ($tasks as $task)
                    <div class="max-w-xs bg-white shadow-lg rounded-lg p-6 relative transform transition duration-300 hover:scale-105 hover:shadow-xl border-2 border-gray-200 flex flex-col w-full sm:w-1/2 lg:w-1/3">
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-600 via-blue-500 to-teal-400 rounded-tl-sm rounded-tr-sm"></div>

                        <!-- Title centred and coloured according to category -->
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center ">
                            {{ $task->title }}
                        </h3>
                        <hr>

                        <!-- Category colours-->
                        @php
                            $categoryColors = [
                                'Ménage' => 'bg-blue-50',
                                'Rangement' => 'bg-purple-50',
                                'Courses groupées' => 'bg-green-50',
                                'Courses urgentes' => 'bg-green-50',
                                'Vaisselle' => 'bg-cyan-50',
                                'Cuisine' => 'bg-orange-50',
                                'Achats communs' => 'bg-lime-50',
                                'Maintenance' => 'bg-gray-50',
                                'Événement' => 'bg-pink-50',
                                'Invités' => 'bg-rose-50',
                                'Réunions' => 'bg-indigo-50',
                                'Visites des locaux' => 'bg-yellow-50',
                                'Prise en main des stagiaires' => 'bg-red-50',
                                'Autre' => 'bg-neutral-50',
                            ];
                            $color = $categoryColors[$task->category] ?? 'bg-gray-400';
                        @endphp

                        <!-- Category -->
                        <p class="text-sm text-gray-600 mt-4 mb-4">
                            <span class="{{ $color }} text-slate-950 px-2 py-1 rounded-md text-xs border">
                                {{ $task->category }}
                            </span>
                        </p>

                        <!-- Description in italics -->
                        <p class="text-sm text-gray-600 mb-4 italic">{{ $task->description }}</p>

                        <!-- Actions pour pointer, commenter, etc. -->
                        @can('point', App\Models\Task::class)
                            <hr>
                            <div class="flex justify-center space-x-2 mt-4 mb-4">
                                @if(auth()->user()->school()->pivot->role === 'student' && !in_array(auth()->user()->id, $task->users->pluck('id')->toArray()))
                                    <a href="{{ route('tasks.show', $task->id) }}" class="bg-emerald-500 hover:bg-emerald-600 !text-white px-4 py-2 rounded-lg text-sm transition duration-300 ease-in-out transform hover:scale-105">
                                        Valider la Tâche
                                    </a>
                                @elseif(auth()->user()->school()->pivot->role === 'student' && in_array(auth()->user()->id, $task->users->pluck('id')->toArray()))
                                    <div class="mt-2">
                                        <p class="font-medium">Votre commentaire :</p>
                                        <p>{{ $task->users->firstWhere('id', auth()->user()->id)->pivot->comment ?? 'Aucun commentaire' }}</p>
                                    </div>
                                @endif
                            </div>
                        @endcan

                        <!-- Actions Buttons -->
                        @can('update', $task)
                        <hr>
                        
                        <div class="flex justify-center space-x-2 mt-4 mb-4">
                        
                            <a href="{{ route('tasks.edit', $task->id) }}" class="bg-orange-400 hover:bg-orange-600 !text-white px-4 py-2 rounded-lg text-sm transition duration-300 ease-in-out transform hover:scale-105">
                                Modifier
                            </a>
                        @endcan
                        @can('delete', $task)
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">

                                @csrf
                                @method('DELETE')
                                <button type="submit" class="!bg-rose-800 hover:!bg-rose-900 !text-white px-4 py-2 rounded-lg text-sm transition duration-300 ease-in-out transform hover:scale-105">
                                    Supprimer
                                </button>
                            </form>
                           
                        </div>
                       
                        <hr>
                        @endcan

                        <!-- Task details (User and Date) -->
                        <div class="flex justify-between items-center text-xs text-gray-500 mt-3">
                            <span class="font-medium">{{ $task->user->first_name ?? ' ' }} {{ $task->user->last_name ?? ' ' }}</span>
                            <span>{{ $task->created_at->format('d/m/Y H:i') }}</span>
                        </div>


                        
                    </div>

                    
                @empty
                    <!-- Display an image when the task list is empty -->
                    <div class="w-full text-center">
                    <img src="{{ asset('images/empty.svg') }}" alt="Aucune tâche" class="mx-auto w-1/2">

                        <p class="text-gray-500 mt-4">Il n'y a pas encore de tâches à afficher.</p>
                    </div>
                @endforelse

            

            </div>

            

            <div class="pt-5 px-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    <!-- end: grid -->
</x-app-layout>
