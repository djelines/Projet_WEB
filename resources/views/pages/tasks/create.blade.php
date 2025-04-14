<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-blue-600">{{ __('Vie Commune') }}</span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="max-w-3xl mx-auto mt-4 !shadow-xl bg-slate-50 rounded-2xl border-6 dark:bg-[--tw-page-bg-dark] ">
        <h1 class="text-2xl font-semibold text-white p-6 items-center text-center bg-gradient-to-r from-indigo-600 via-blue-500 to-teal-400 rounded-tl-2xl rounded-tr-2xl ">Créer une Tâche</h1>
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4 p-8 bg-white dark:bg-[--tw-page-bg-dark] rounded-xl shadow-lg">
                @csrf

                <div class="space-y-2">
                    <label for="title" class="block text-base font-semibold text-gray-800">Titre</label>
                    <input type="text" name="title" id="title"
                        value="{{ old('title') }}"
                        class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Entrez un titre...">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>


                <div class="space-y-2">
                    <label for="description" class="block text-base font-semibold text-gray-800">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                        placeholder="Ajoutez des détails..." ></textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>
                <div class="space-y-2">
    <label for="cohorts" class="block text-base font-semibold text-gray-800">Affecter à une ou plusieurs promotions</label>
    <select name="cohorts[]" id="cohorts" multiple required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-white dark:bg-[--tw-page-bg-dark] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        @foreach ($cohorts as $cohort)
            <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
        @endforeach
    </select>
    <p class="text-sm text-gray-500">Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs promotions.</p>
    @error('cohorts')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <div class="space-y-2">
                    <label for="category" class="block text-base font-semibold text-gray-800 ">Catégorie</label>
                        <select name="category" id="category"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg dark:bg-[--tw-page-bg-dark] shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            <option value="" disabled selected>— Sélectionner une catégorie —</option>
                            <option value="Ménage">Ménage</option>
                            <option value="Rangement">Rangement</option>
                            <option value="Courses groupées">Courses groupées</option>
                            <option value="Courses urgentes">Courses urgentes</option>
                            <option value="Vaisselle">Vaisselle</option>
                            <option value="Cuisine">Cuisine</option>
                            <option value="Achats communs">Achats communs</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Événement">Événement</option>
                            <option value="Invités">Invités</option>
                            <option value="Réunions">Réunions</option>
                            <option value="Visites des locaux">Visites des locaux</option>
                            <option value="Prise en main des stagiaires">Prise en main des stagiaires</option>
                            <option value="Autre">Autre</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>


                <!-- Buttons -->
                <div class="flex flex-row items-end justify-end pt-4 border-gray-200 gap-4">
                    <!-- Back -->
                    <a href="{{ route('tasks.index') }}"
                    class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                        ← Revenir
                    </a>

                    <!-- Create -->
                    <button type="submit"
                    class="!px-4 py-2 !bg-teal-600 !text-white rounded-lg font-semibold text-sm transition duration-300 ease-in-out transform hover:!bg-teal-700 hover:scale-105 uppercase">
                        Créer →
                    </button>
                </div>
            </form>
        </div>
    <!-- end: grid -->
</x-app-layout>
