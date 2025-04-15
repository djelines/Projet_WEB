<?php

use App\Http\Controllers\CohortController;
use App\Http\Controllers\CommonLifeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


// Redirect the root path to /dashboard
Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cohorts
        Route::get('/cohorts', [CohortController::class, 'index'])->name('cohort.index');
        Route::get('/cohort/{cohort}', [CohortController::class, 'show'])->name('cohort.show');

        // Teachers
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.index');

        // Students
        Route::get('students', [StudentController::class, 'index'])->name('student.index');

        // Knowledge
        Route::get('knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');

        // Route pour afficher le formulaire de création de bilan
        Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
        Route::get('/knowledge/create', [KnowledgeController::class, 'create'])->name('knowledge.create');
        Route::post('/knowledge/store', [KnowledgeController::class, 'store'])->name('knowledge.store');
        Route::get('/knowledge/{id}', [KnowledgeController::class, 'show'])->name('knowledge.show');
        Route::delete('/knowledge/{id}', [KnowledgeController::class, 'destroy'])->name('knowledge.destroy');
        Route::post('/knowledge/{assessment}/submit', [KnowledgeController::class, 'submit'])->name('knowledge.submit');
        Route::get('/knowledge/result/{id}', [KnowledgeController::class, 'result'])->name('knowledge.result');
        Route::get('/knowledge/{assessment}/history', [KnowledgeController::class, 'history'])
            ->name('knowledge.history'); 
            Route::get('/knowledge/result/{id}', [KnowledgeController::class, 'result'])->name('knowledge.result');




        // Groups
        Route::get('groups', [GroupController::class, 'index'])->name('group.index');

        // Retro
        route::get('retros', [RetroController::class, 'index'])->name('retro.index');

        // Common life
        //Route::get('common-life', [CommonLifeController::class, 'index'])->name('common-life.index');

        // Tasks
        // Route de complétion + historique, définie avant le resource
        
        // Admins only
        Route::middleware(['can:manage,App\Models\Task'])->group(function () {
            Route::resource('tasks', TaskController::class)->except(['index', 'show']);
        });

        // History Task Completed 
        Route::get('/tasks/completed-by-students', [TaskController::class, 'completedByStudents'])
        ->name('tasks.completedByStudents');

        // History
        Route::get('/tasks/history', [TaskController::class, 'viewHistory'])->name('tasks.history');

        // Access to tasks visible to all (but actions limited according to role)
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

        // Point to a task
        Route::patch('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])
            ->middleware('can:point,App\Models\Task')
            ->name('tasks.complete');
    });

});

require __DIR__.'/auth.php';
