<x-app-layout>
    <!-- Stylized header -->
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">{{ __('Bilans de Compétence') }}</span>
        </h1>
    </x-slot>

    <!-- Main container -->
    <div class="max-w-3xl mx-auto mt-4 shadow-xl bg-slate-50 rounded-2xl border-6 dark:bg-[--tw-page-bg-dark]">
        <!-- Gradient title banner -->
        <h1 class="text-2xl font-semibold text-white p-6 text-center bg-gradient-to-r from-pink-600 via-purple-500 to-indigo-500 rounded-tl-2xl rounded-tr-2xl">
            Créer un Bilan de Compétence
        </h1>

        <!-- Form -->
        <form method="POST" id="formConfirm" action="{{ route('knowledge.store') }}" class="space-y-6 p-8 bg-white dark:bg-[--tw-page-bg-dark] rounded-xl !shadow-xl">
            @csrf

            <!-- Languages -->
            <div class="space-y-2">
                <label for="languages" class="block text-base font-semibold text-gray-800">Langages à évaluer</label>
                <select name="languages[]" id="languages" multiple class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition duration-200">
                    @foreach($languages as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500">Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs langages.</p>

                @error('languages')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Number of questions -->
            <div class="space-y-2">
                <label for="num_questions" class="block text-base font-semibold text-gray-800">Nombre de questions</label>
                <input type="number" name="num_questions" id="num_questions" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition duration-200" value="{{ old('num_questions') }}" min="2"
                max="20" placeholder="Ex : 10"> @error('num_questions')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Number of answers per question -->
            <div class="space-y-2">
                <label for="num_answers" class="block text-base font-semibold text-gray-800">Nombre de réponses par question</label>
                <input type="number" name="num_answers" id="num_answers" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition duration-200" value="{{ old('num_answers', 4) }}" min="2"
                max="6" placeholder="Ex : 4"> @error('num_answers')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cohort selection -->
            <div class="space-y-2">
                <label for="cohort_id" class="block text-base font-semibold text-gray-800">Promo concernée</label>
                <select name="cohort_id" id="cohort_id" required class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition duration-200">
                    @foreach ($cohorts as $cohort)
                    <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                    @endforeach
                </select>
                @error('cohort_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end items-center gap-4 pt-4">
                <a href="{{ route('knowledge.index') }}" class="bg-purple-700 hover:bg-purple-900 px-4 py-2 rounded-lg !text-white text-sm font-semibold transition duration-300 ease-in-out transform hover:scale-105 uppercase">
                    ← Retour
                </a>

                <button type="submit" class="px-4 py-2 !bg-pink-600 !text-white rounded-lg font-semibold text-sm transition duration-300 ease-in-out transform hover:bg-pink-700 hover:scale-105 uppercase">
                    Générer →
                </button>
            </div>
        </form>
    </div>

    <!-- Load SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Load compiled app.js file -->
    <script src="{{ mix('js/app.js') }}"></script>
</x-app-layout>
