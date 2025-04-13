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
use \App\Models\AssessmentResult; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Cohort;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\SubmitAssessmentRequest;
use App\Http\Requests\IndexAssessmentRequest;




class KnowledgeController extends Controller
{

    use AuthorizesRequests; 
    /**
     * Affiche la page des bilans de compétence depuis la base de données.
     */
    public function index(IndexAssessmentRequest $request)
    {
        // Récupérer les paramètres validés
        $order = $request->get('sort', 'desc');  // Par défaut, tri du plus récent au plus ancien
        $sortBy = $request->get('sort_by', 'created_at');  // Tri par défaut sur created_at
        
        // Récupérer l'id de la cohorte de l'utilisateur connecté via la table pivot
        $userCohortId = auth()->user()->cohorts()->first()->id;
    
        // Applique le tri et le filtre sur le bon champ et la cohorte de l'utilisateur connecté
        $assessments = Assessment::where('cohort_id', $userCohortId)
                                ->orderBy($sortBy, $order)
                                ->paginate(6);  // Utilisation de la pagination
    
        return view('pages.knowledge.index', compact('assessments', 'order', 'sortBy'));
    }
    



    /**
     * Affiche le formulaire de création de bilan
     */
    public function create()
    {
        $this->authorize('create', Assessment::class);
        $languages = ['PHP', 'JavaScript', 'Python', 'Java', 'C++'];
        $cohorts = Cohort::all();

        return view('pages.knowledge.create', compact('languages', 'cohorts'));
    }


    /**
     * Gère la soumission du formulaire pour créer un bilan 
     */
    public function store(StoreAssessmentRequest $request)
    {
        $validated = $request->validated();  // La validation est déjà faite à ce point

        $cohort = Cohort::findOrFail($validated['cohort_id']);

        // Vérifier si l'utilisateur appartient à cette cohorte
        if (!Auth::user()->cohorts->contains($cohort)) {
            return back()->with('error', 'Vous ne faites pas partie de cette cohorte.');
        }

        // Générer le QCM
        $qcm = $this->generateQCM($validated['languages'], $validated['num_questions'], $validated['num_answers']);

        if (isset($qcm['error'])) {
            return back()->with('error', $qcm['error']);
        }

        // Créer l'évaluation sans le champ "difficulty"
        $assessment = Assessment::create([
            'languages' => $validated['languages'],
            'num_questions' => $validated['num_questions'],
            'questions' => json_encode($qcm),
            'user_id' => Auth::id(),
            'cohort_id' => $validated['cohort_id'],
        ]);

        return view('pages.knowledge.show', ['qcm' => $qcm, 'assessment' => $assessment]);
    }



    /**
     * Affiche un bilan spécifique
     */
    // Afficher uniquement les évaluations assignées à l'étudiant
    public function show($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorize('view', $assessment);

        $qcm = is_string($assessment->questions)
            ? json_decode($assessment->questions, true)
            : $assessment->questions;

        return view('pages.knowledge.show', compact('assessment', 'qcm'));
    }





    /**
     * Supprime un bilan
     */
    public function destroy($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorize('delete', $assessment);
        $assessment->delete();

        return redirect()->route('knowledge.index')->with('success', 'Bilan supprimé avec succès');
    }


    /**
     * Génère un QCM avec Gemini
     */
    private function generateQCM(array $languages, int $numQuestions, int $numAnswers)
    {
        // Déterminer les proportions de questions selon la difficulté
        $easyCount = ceil($numQuestions * 0.30);
        $mediumCount = ceil($numQuestions * 0.40);
        $hardCount = $numQuestions - ($easyCount + $mediumCount);

        // Préparer le prompt pour Gemini avec la nouvelle description
        $prompt = "Je veux générer un QCM pour évaluer des étudiants sur les langages suivants : " . implode(', ', $languages) . ". Crée exactement $numQuestions questions à choix multiples. Les questions doivent être directement liées aux langages fournis. Chaque question doit comporter $numAnswers choix, dont une seule bonne réponse. La réponse doit être au format JSON uniquement. Voici la structure des questions :
        - \"question\" : le texte de la question
        - \"choices\" : un tableau de choix
        - \"correct_answer\" : la bonne réponse

        Les questions doivent être équilibrées en termes de difficulté :
        - $easyCount questions faciles
        - $mediumCount questions moyennes
        - $hardCount questions difficiles

        Merci de générer le QCM selon ces spécifications.";
        
        // Envoi à l'IA pour générer les questions
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . config('services.gemini.api_key'), [
            'contents' => [[ 'parts' => [[ 'text' => $prompt ]] ]]
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                $questionsJson = trim($responseData['candidates'][0]['content']['parts'][0]['text']);
                $questionsJson = preg_replace('/^```(json)?|```$/i', '', $questionsJson);

                $questions = json_decode($questionsJson, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($questions) && count($questions) > 0) {
                    return $questions;
                }
                return ['error' => 'Format JSON non valide ou aucune question.'];
            }
        }

        return ['error' => 'Erreur lors de la génération du QCM.'];
    }


    public function submit(SubmitAssessmentRequest $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $user = Auth::user();
    
        // Vérifier si l'étudiant a déjà répondu à ce bilan
        $existingResult = AssessmentResult::where('assessment_id', $assessment->id)
                                            ->where('user_id', $user->id)
                                            ->first();
    
        if ($existingResult) {
            return redirect()->route('knowledge.result', $existingResult->id)
                             ->with('error', 'Vous avez déjà répondu à ce bilan.');
        }
    
        // Si non, on poursuit le traitement
        $qcm = is_string($assessment->questions) ? json_decode($assessment->questions, true) : $assessment->questions;
        $userAnswers = $request->input('answers', []);
        $score = 0;
    
        foreach ($qcm as $index => $question) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] === $question['correct_answer']) {
                $score++;
            }
        }
    
        // Enregistrer les résultats
        $result = AssessmentResult::create([
            'assessment_id' => $assessment->id,
            'user_id' => $user->id,
            'answers' => $userAnswers,
            'score' => $score,
        ]);
    
        // Passer à la vue des résultats
        return redirect()->route('knowledge.result', $result->id);
    }
    




    public function result($id)
    {
        $result = AssessmentResult::with('assessment')->findOrFail($id);

        $qcm = is_string($result->assessment->questions)
            ? json_decode($result->assessment->questions, true)
            : $result->assessment->questions;

        return view('pages.knowledge.result', [
            'assessment' => $result->assessment,
            'score' => $result->score,
            'userAnswers' => $result->answers,
            'qcm' => $qcm,
        ]);
    }



    public function history($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->authorize('viewHistory', $assessment);

        $results = AssessmentResult::with('user')
            ->where('assessment_id', $assessment->id)
            ->orderByDesc('created_at')
            ->get();

        return view('pages.knowledge.history', compact('assessment', 'results'));
    }




}
