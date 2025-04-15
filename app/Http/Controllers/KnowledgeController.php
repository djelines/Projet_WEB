<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Assessment;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\AssessmentResult;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cohort;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\SubmitAssessmentRequest;
use App\Http\Requests\IndexAssessmentRequest;


class KnowledgeController extends Controller
{
    use AuthorizesRequests;
    
    
    /**
     * Displays the skills assessment page from the database.
     */
    public function index(IndexAssessmentRequest $request)
    {
        // Retrieve the validated parameters
        $order = $request->get("sort", "desc"); // Default sorting: from newest to oldest
        $sortBy = $request->get("sort_by", "created_at"); // Default sorting by created_at
        $search = $request->get('search');

        // Retrieve the cohort id of the connected user via the pivot table
        $userCohortIds = auth()->user()->cohorts->pluck('id');

        // Apply sorting and filtering to the correct field and cohort of the logged-in user
        $query = Assessment::whereIn("cohort_id", $userCohortIds);

        // filtrer les bilans contenant ce mot dans : l’ID du bilan, les langages (JSON array), le prénom / nom du créateur.
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where("id", "like", "%{$search}%")
                ->orWhereJsonContains('languages', $search)
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }

        $assessments = $query->orderBy($sortBy, $order)->paginate(6);

        return view("pages.knowledge.index", compact("assessments", "order", "sortBy", "search"));
    }


    /**
     * Displays the balance sheet creation form
     */
    public function create()
    {
        // Authorization check (policies)
        $this->authorize("create", Assessment::class);
        // Available programming languages
        $languages = ["Angular", "C#", "C++", "Dart", "Docker", "Django", "Express.js", 
        "Flask", "Git", "Go", "GraphQL", "Java", "JavaScript", "Kotlin", "Laravel", "NestJS", 
        "Next.js", "Node.js", "PHP", "Python", "React", "Rust", "SQL", "Spring Boot", "Svelte", 
        "Swift", "Symfony", "TypeScript", "Vue.js"];

        // Retrieve all cohorts
        $cohorts = Cohort::all();

        return view("pages.knowledge.create", compact("languages", "cohorts"));
    }

    /**
     * Handles the form submission to create a new skill assessment.
     */
    public function store(StoreAssessmentRequest $request)
    {
        $validated = $request->validated(); // Validation is already done at this point

        // Find the corresponding cohort
        $cohort = Cohort::findOrFail($validated["cohort_id"]);

        // Check if the user belongs to this cohort
        if (!Auth::user()->cohorts->contains($cohort)) {
            return back()->with(
                "error",
                "You are not part of this cohort."
            );
        }

        // Generate the multiple-choice questionnaire (MCQ)
        $qcm = $this->generateQCM(
            $validated["languages"],
            $validated["num_questions"],
            $validated["num_answers"]
        );

        if (isset($qcm["error"])) {
            return back()->with("error", $qcm["error"]);
        }

        // Create the assessment without the "difficulty" field
        $assessment = Assessment::create([
            "languages" => $validated["languages"],
            "num_questions" => $validated["num_questions"],
            "questions" => json_encode($qcm),
            "user_id" => Auth::id(),
            "cohort_id" => $validated["cohort_id"],
        ]);

        return view("pages.knowledge.show", [
            "qcm" => $qcm,
            "assessment" => $assessment,
        ]);
    }


    /**
     * Displays a specific skill assessment.
     */
    public function show($id)
    {
        // Display only the assessments assigned to the student
        $assessment = Assessment::findOrFail($id);
        $this->authorize("view", $assessment);

        // Check if the questions are in JSON string format
        // If it's a string, decode the JSON string into an associative array
        // If it's not a string (probably already an array), use it as it is
        $qcm = is_string($assessment->questions)
        ? // If it's a string, decode the JSON string into an associative array
        json_decode($assessment->questions, true)
        : // If it's not a string (probably already an array), use it as it is
        $assessment->questions;

        return view("pages.knowledge.show", compact("assessment", "qcm"));
    }


    /**
     * Delete a skill assessment. 
     */
    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorize("delete", $assessment);
        $assessment->delete();

        return redirect()
            ->route("knowledge.index")
            ->with("success", "Bilan supprimé avec succès");
    }

    /**
     * Generates a multiple-choice questionnaire (MCQ) using Gemini.
     */
    private function generateQCM(
        array $languages,
        int $numQuestions,
        int $numAnswers
    ) {
        // Determine the proportion of questions based on difficulty
        $easyCount = ceil($numQuestions * 0.3);
        $mediumCount = ceil($numQuestions * 0.4);
        $hardCount = $numQuestions - ($easyCount + $mediumCount);

        // Prepare the prompt for Gemini with the new description
        $prompt =
            "Je veux générer un QCM pour évaluer des étudiants sur les langages suivants : " .
            implode(", ", $languages) .
            ". Crée exactement $numQuestions questions à choix multiples. Les questions doivent être directement liées aux langages fournis. Chaque question doit comporter $numAnswers choix, dont une seule bonne réponse. 
            Chaque question ne peut avoir que une seule bonne réponse. La réponse doit être au format JSON uniquement. Voici la structure des questions :
        - \"question\" : le texte de la question
        - \"choices\" : un tableau de choix
        - \"correct_answer\" : la bonne réponse

        Les questions doivent être équilibrées en termes de difficulté :
        - $easyCount questions faciles
        - $mediumCount questions moyennes
        - $hardCount questions difficiles

        Merci de générer le QCM selon ces spécifications.";

        // Send the request to Gemini to generate the questions
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" .
                config("services.gemini.api_key"),
            [
                "contents" => [["parts" => [["text" => $prompt]]]],
            ]
        );

        if ($response->successful()) {
            $responseData = $response->json();
            if (
                isset(
                    $responseData["candidates"][0]["content"]["parts"][0][
                        "text"
                    ]
                )
            ) {
                $questionsJson = trim(
                    $responseData["candidates"][0]["content"]["parts"][0][
                        "text"
                    ]
                );
                $questionsJson = preg_replace(
                    '/^```(json)?|```$/i',
                    "",
                    $questionsJson
                );

                $questions = json_decode($questionsJson, true);

                if (
                    json_last_error() === JSON_ERROR_NONE &&
                    is_array($questions) &&
                    count($questions) > 0
                ) {
                    return $questions;
                }
                return [
                    "error" => "Format JSON non valide ou aucune question.",
                ];
            }
        }

        return ["error" => "Erreur lors de la génération du QCM."];
    }

    /**
    * Handle the submission of the assessment.
    */
    public function submit(SubmitAssessmentRequest $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $user = Auth::user();

        // Check if the student has already answered this assessment
        $existingResult = AssessmentResult::where(
            "assessment_id",
            $assessment->id
        )
            ->where("user_id", $user->id)
            ->first();

        if ($existingResult) {
            return redirect()
                ->route("knowledge.result", $existingResult->id)
                ->with("error", "You have already answered this assessment.");
        }

        // If not, continue processing
        $qcm = is_string($assessment->questions)
            ? json_decode($assessment->questions, true)
            : $assessment->questions;
        $userAnswers = $request->input("answers", []);
        $score = 0;

        // Loop through each question and check if the answer is correct
        foreach ($qcm as $index => $question) {
            if (
                isset($userAnswers[$index]) &&
                $userAnswers[$index] === $question["correct_answer"]
            ) {
                $score++;
            }
        }

        // Save the results
        $result = AssessmentResult::create([
            "assessment_id" => $assessment->id,
            "user_id" => $user->id,
            "answers" => $userAnswers,
            "score" => $score,
        ]);

        // Redirect to the result view
        return redirect()->route("knowledge.result", $result->id);
    }

    /**
      * Display the result of the assessment.
      */
    public function result($id)
    {
        // Retrieve the result with its associated assessment
        $result = AssessmentResult::with("assessment")->findOrFail($id);

        // Decode the questions if they are stored as a JSON string
        $qcm = is_string($result->assessment->questions)
            ? json_decode($result->assessment->questions, true)
            : $result->assessment->questions;

        return view("pages.knowledge.result", [
            "assessment" => $result->assessment,
            "score" => $result->score,
            "userAnswers" => $result->answers,
            "qcm" => $qcm,
        ]);
    }

    /**
      * Display the history of the assessment results.
      */
    public function history($id)
    {
        // Retrieve the assessment or fail
        $assessment = Assessment::findOrFail($id);
        // Check if the user is authorized to view the history
        $this->authorize("viewHistory", $assessment);

        // Retrieve all results for this assessment, ordered by most recent
        $results = AssessmentResult::with("user")
            ->where("assessment_id", $assessment->id)
            ->orderByDesc("created_at")
            ->get();

        return view(
            "pages.knowledge.history",
            compact("assessment", "results")
        );
    }

   

    public function downloadResults($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorize("viewHistory", $assessment);

        $results = AssessmentResult::with("user")
            ->where("assessment_id", $assessment->id)
            ->orderByDesc("created_at")
            ->get();

        $pdf = Pdf::loadView('pages.knowledge.assessmentPdf', compact('assessment', 'results'));

        return $pdf->download('resultats_bilan_'.$assessment->id.'.pdf');
    }

}
