<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;



class TaskController extends Controller
{
    // Using php artisan make:controller TaskController --resource 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->get();
        $tasks = Task::paginate(9);
        return view('tasks.index', compact('tasks'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            ''
        ]);

        // Si la validation échoue, Laravel redirigera l'utilisateur et injectera les erreurs dans la session.
        // Si la validation réussit, l'exécution continue normalement.
    
        // Création de la tâche si validation réussie

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category, 
            'user_id' => Auth::id(),
        ]);
        
        // dd($request->all());  // Ceci va afficher toutes les données envoyées dans la requête


        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        $task->update($request->only('title', 'description', 'category'));

        return redirect()->route('tasks.index')->with('success', 'Tâche \'' . $task->title . '\' modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche \'' . $task->title . '\' supprimée !');

    }
}
