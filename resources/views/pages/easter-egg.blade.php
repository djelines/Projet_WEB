<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-xl font-semibold text-gray-800">
            <span class="text-pink-600">Écrase le bug !</span>
        </h1>
    </x-slot>

    <div class="relative bg-white dark:bg-[--tw-page-bg-dark] shadow-md rounded-xl p-6 mb-8 border-2 border-gray-200 overflow-hidden h-[80vh]">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-500 via-purple-400 to-indigo-400 rounded-tl-sm rounded-tr-sm"></div>

        <div id="game-info" class="flex justify-between items-center mb-6">
            <div id="score" class="bg-pink-100 text-pink-800 font-semibold px-4 py-2 rounded-full shadow">Score : 0</div>
            <div id="timer" class="bg-indigo-100 text-indigo-800 font-semibold px-4 py-2 rounded-full shadow">Temps : 00:00</div>
            <div id="missed" class="bg-yellow-100 text-yellow-800 font-semibold px-4 py-2 rounded-full shadow">Manqué : 0</div>
        </div>

        <div id="game-area" class="relative w-full h-10/12 rounded-lg overflow-hidden bg-gradient-to-br from-indigo-100 via-pink-100 to-rose-100"></div>
    </div>

    <!-- MODALE DE DEFAITE -->
    <div id="game-over-popup" class="hidden absolute inset-0 flex items-center justify-center z-50 pointer-events-none">
        <div class="bg-white p-8 rounded-xl text-center shadow-lg max-w-sm w-full pointer-events-auto">
            <h2 class="text-2xl font-bold text-red-600 mb-4">Perdu !</h2>
            <p id="final-score" class="text-lg mb-2">Score : 0</p>
            <p id="final-time" class="text-lg mb-4">Temps : 00:00</p>
            <a href="{{ route('easter-egg') }}" class="bg-pink-600 !text-white px-6 py-2 rounded-lg hover:bg-pink-700 transition">
                Recommencer
            </a>
        </div>
    </div>



    <!-- Retour au tableau de bord -->
    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 !text-white font-semibold px-6 py-2 rounded-lg transition duration-300 ease-in-out">
            ← Revenir au tableau de bord
        </a>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    <style>
        #game-over-popup.show > div {
            transform: scale(1) !important;
            opacity: 1 !important;
        }
    </style>
</x-app-layout>
