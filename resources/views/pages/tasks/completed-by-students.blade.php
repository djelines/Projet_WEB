<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-blue-600">{{ __('Vie Commune') }}</span>
        </h1>
    </x-slot>
    
    <div class="space-y-8 p-6">
        @forelse ($tasks as $task)
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800">{{ $task->title }}</h3>
                
                <ul class="mt-4 space-y-2">
                    @forelse ($task->completedStudents as $student)
                        <li class="flex justify-between items-center p-2 bg-gray-100 rounded-md">
                            <span class="text-gray-800">{{ $student->getFullNameAttribute() }}</span>
                            <span class="text-sm text-gray-500">Complété</span>
                        </li>
                    @empty
                        <li class="p-2 bg-gray-100 text-gray-600 rounded-md">
                            Aucun élève n’a encore complété cette tâche.
                        </li>
                    @endforelse
                </ul>
            </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">Aucune tâche terminée pour le moment.</p>
                </div>
            @endforelse
            <div class="pt-5 px-4">
                {{ $tasks->links() }}
            </div>
            <div class="mt-6 text-left">
            <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        ← Revenir
            </a>
        </div>
    </div>
</x-app-layout>
