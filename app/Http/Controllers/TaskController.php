<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTaskRequest;


class TaskController extends Controller
{
    // Using php artisan make:controller TaskController --resource 

    /**
     * Display a listing of the resource.
     * Page blade which take to the modifications page 
     */
    public function index(Request $request)
    {
        
        $sortOrder = $request->get('sort', 'asc');  // If “sort” is present in the URL, otherwise use “asc” by default

        $tasks = Task::orderBy('created_at', $sortOrder)->paginate(9); // Allows tasks to be sorted and paginated

        return view('pages.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     * Page blade which take to the creation page 
     */
    public function create()
    {
        return view('pages.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
       

        // Used to send the query to the table
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            ''
        ]);

        // If validation fails, Laravel will redirect the user and inject the errors into the session.
        // If validation succeeds, execution will continue as normal.
            
        // Creation of the task if validation succeeds.
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category, 
            'user_id' => Auth::id(),
        ]);
        
        // dd($request->all());  // This will display all the data sent in the request

        // Redirects to the index page with the success message
        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        return view('pages.tasks.show', compact('task'));

    }

    /**
     * Show the form for editing the specified resource.
     * Page blade which take to the modifications page 
     */
    public function edit(Task $task)
    {   
        return view('pages.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        // Used to send the query to the table
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
        ]);

        // Modifies and updates new valueste 
        $task->update($request->only('title', 'description', 'category'));

        // Redirects to the index page with the success message
        return redirect()->route('tasks.index')->with('success', 'Tâche \'' . $task->title . '\' modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        // Redirects to the index page with the success message
        return redirect()->route('tasks.index')->with('success', 'Tâche \'' . $task->title . '\' supprimée !');

    }

    /**
     * 
     */
    public function markAsCompleted(Task $task, Request $request)
    {
        $user = auth()->user();
        $userRole = $user->school()->pivot->role;

        if ($userRole !== 'student') {
            return back()->withErrors('Seuls les étudiants peuvent marquer des tâches comme terminées.');
        }

        // Vérifier si l'utilisateur a déjà pointé cette tâche
        $taskUser = $task->users()->where('user_id', $user->id)->first();

        if (!$taskUser) {
            // Ajouter une nouvelle entrée pour l'utilisateur
            $task->users()->attach($user->id, [
                'completed' => true,
                'comment' => $request->input('comment'),
            ]);
        } else {
            return back()->with('error', 'Tâche déjà pointée.');
        }

        // Redirects to the index page with the success message
        return redirect()->route('tasks.index')->with('success', 'Tâche : \'' . $task->title . '\' marquée comme terminée !');
        
    }

    /**
     * 
     * 
     */
    public function viewHistory()
    {
        $user = auth()->user();
        $completedTasks = $user->tasks()->wherePivot('completed', true)->get();

        return view('pages.tasks.history', compact('completedTasks'));
    }


}
