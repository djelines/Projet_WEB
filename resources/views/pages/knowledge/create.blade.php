<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold">{{ __('Créer un bilan de compétence') }}</h1>
    </x-slot>

    <div class="container mx-auto my-8">
        <form method="POST" action="{{ route('knowledge.store') }}">
            @csrf
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

            <div class="mb-4">
                <label for="num_questions" class="block text-sm font-medium text-gray-700">Nombre de questions</label>
                <input type="number" name="num_questions" id="num_questions" class="form-input mt-1 block w-full" value="{{ old('num_questions') }}" min="1" max="20">
                @error('num_questions')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Générer le bilan</button>
        </form>
    </div>
</x-app-layout>
