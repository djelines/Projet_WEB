<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Dashboard') }}
            </span>
        </h1>
    </x-slot>

    <!-- begin: grid -->
    <div class="grid lg:grid-cols-3 gap-5 lg:gap-7.5 items-stretch">
        <div class="lg:col-span-2">
            <div class="grid">
                <div class="card card-grid h-full min-w-full">
                    <div class="card-header">
                        <h3 class="card-title">
                        <div class="container">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                            <h1>Créer une tâche</h1>

                            <form action="{{ route('tasks.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Catégorie</label>
                                    <select name="category" id="category" class="form-select" required>
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
                                </div>


                                <button type="submit" class="btn btn-primary">Créer</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- end: grid -->
</x-app-layout>
