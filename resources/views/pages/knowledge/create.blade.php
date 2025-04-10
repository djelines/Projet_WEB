<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold">{{ __('Créer un bilan de compétence') }}</h1>
    </x-slot>

    <div class="container mx-auto my-8">
        <form method="POST" action="{{ route('knowledge.store') }}">
            @csrf

            <!-- Langages -->
            <div class="mb-4">
                <label for="languages" class="block text-sm font-medium text-gray-700">Langages à évaluer</label>
                <select name="languages[]" id="languages" multiple class="form-select mt-1 block w-full">
                    @foreach($languages as $language)
                        <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>
                @error('languages')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nombre de questions -->
            <div class="mb-4">
                <label for="num_questions" class="block text-sm font-medium text-gray-700">Nombre de questions</label>
                <input type="number" name="num_questions" id="num_questions" class="form-input mt-1 block w-full" value="{{ old('num_questions') }}" min="1" max="20">
                @error('num_questions')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Difficulté -->
            <div class="mb-4">
                <label for="difficulty" class="block text-sm font-medium text-gray-700">Niveau de difficulté</label>
                <select name="difficulty" id="difficulty" class="form-select mt-1 block w-full">
                    <option value="débutant">Débutant</option>
                    <option value="intermédiaire">Intermédiaire</option>
                    <option value="expert">Expert</option>
                </select>
                @error('difficulty')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn btn-primary">Générer le bilan</button>
        </form>
        <a href="{{ route('knowledge.index') }}" class="btn btn-primary">Retour</a>
    </div>
</x-app-layout>
