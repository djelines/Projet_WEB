<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Models\Assessment;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class KnowledgeController extends Controller
{
    /**
     * Affiche la page des bilans de compétence depuis la base de données.
     */
    public function index(Request $request)
    {
        $order = $request->get('sort', 'desc'); // Par défaut, tri du plus récent au plus ancien

        // Vérifie si le tri est demandé par ID ou par date
        $sortBy = $request->get('sort_by', 'created_at'); // tri par défaut sur created_at

        // Applique le tri sur le bon champ
        $assessments = Assessment::orderBy($sortBy, $order)->get();

        return view('pages.knowledge.index', compact('assessments', 'order', 'sortBy'));
    }




    /**
     * Affiche le formulaire de création de bilan
     */
    public function create()
    {
        $languages = ['PHP', 'JavaScript', 'Python', 'Java', 'C#'];
        return view('pages.knowledge.create', compact('languages'));
    }

    /**
     * Gère la soumission du formulaire pour créer un bilan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'languages' => 'required|array|min:1',
            'num_questions' => 'required|integer|min:1|max:20',
            'difficulty' => 'required|string|in:débutant,intermédiaire,expert',
            
        ]);

        $qcm = $this->generateQCM($validated['languages'], $validated['num_questions'], $validated['difficulty']);

        if (isset($qcm['error'])) {
            return back()->with('error', $qcm['error']);
        }

        $assessment = Assessment::create([
            'languages' => $validated['languages'],
            'num_questions' => $validated['num_questions'],
            'difficulty' => $validated['difficulty'],
            'questions' => $qcm,
            
        ]);

        return view('pages.knowledge.show', ['qcm' => $qcm, 'assessment' => $assessment]);
    }

    /**
     * Affiche un bilan spécifique
     */
    public function show($id)
    {
        $assessment = Assessment::findOrFail($id);
        
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
        $assessment->delete();
        return redirect()->route('knowledge.index')->with('success', 'Bilan supprimé avec succès');
    }

    /**
     * Génère un QCM avec Gemini
     */
    private function generateQCM(array $languages, int $numQuestions, string $difficulty)
    {
        $prompt = "Je veux générer un QCM de niveau $difficulty pour évaluer des étudiants sur les langages suivants : " . implode(', ', $languages) . ". Crée exactement $numQuestions questions à choix multiples. Les questions doivent être directement liées aux langages fournis. La réponse doit être au format JSON uniquement. Chaque question doit contenir :
        - \"question\" : le texte de la question
        - \"choices\" : un tableau de choix
        - \"correct_answer\" : la bonne réponse.";

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
                \Log::debug("JSON nettoyé : " . $questionsJson);

                $questions = json_decode($questionsJson, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($questions) && count($questions) > 0) {
                    return $questions;
                }
                return ['error' => 'Format JSON non valide ou aucune question.'];
            }
        }

        return ['error' => 'Erreur lors de la génération du QCM.'];
    }
}
