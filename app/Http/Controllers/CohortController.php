<?php

namespace App\Http\Controllers;

use App\Models\Cohort;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CohortController extends Controller
{
    /**
     * Display all available cohorts
     * @return Factory|View|Application|object
     */
    public function index() {

        $cohorts = Cohort::all();

        return view('pages.cohorts.index', [
            'cohorts' => $cohorts
        ]);
    }

    public function create()
    {
        $cohorts = Cohort::all();
        return view('assessments.create', compact('cohorts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'languages' => 'required|string',
            'difficulty' => 'required|string',
            'num_questions' => 'required|integer',
            'cohort_id' => 'required|exists:cohorts,id',
            // autres validations...
        ]);

        $assessment = new Assessment($validated);
        $assessment->user_id = auth()->id();
        $assessment->save();

        return redirect()->route('assessments.index');
    }



    /**
     * Display a specific cohort
     * @param Cohort $cohort
     * @return Application|Factory|object|View
     */
    public function show(Cohort $cohort) {

        return view('pages.cohorts.show', [
            'cohort' => $cohort
        ]);
    }
}
