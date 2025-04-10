<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KnowledgeController extends Controller
{
    /**
     * Affiche la page des bilans de compétence.
     *
     * @return Factory|View|Application|object
     */
    public function index() {
        $assessments = [
            // Exemple de bilans générés, normalement tu utiliseras une base de données
        ];

        return view('pages.knowledge.index', compact('assessments'));
    }

    /**
     * Affiche le formulaire de création de bilan
     */
    public function create()
    {
        $languages = ['PHP', 'JavaScript', 'Python', 'Java', 'C#']; // Liste des langages disponibles pour l'évaluation

        return view('pages.knowledge.create', compact('languages'));
    }

    /**
     * Gère la soumission du formulaire pour créer un bilan
     */
    public function store(Request $request)
    {
        // Validation des données envoyées
        $validated = $request->validate([
            'languages' => 'required|array|min:1',
            'num_questions' => 'required|integer|min:1|max:20',
        ]);

        // Appel à l'API Gemini pour générer des QCM
        $qcm = $this->generateQCM($validated['languages'], $validated['num_questions']);

        // Retourner la vue avec le QCM généré
        return view('pages.knowledge.show', compact('qcm'));
    }

    /**
     * Affiche le bilan de compétence généré
     */
    public function show($id)
    {
        // Logique pour récupérer un bilan spécifique à partir de la base de données
        $assessment = [
            'id' => $id,
            'languages' => ['PHP', 'JavaScript'],
            'num_questions' => 5,
            'created_at' => '2025-04-10 14:00:00',
        ];

        return view('pages.knowledge.show', compact('assessment'));
    }

    /**
     * Supprime un bilan de compétence
     */
    public function destroy($id)
    {
        return redirect()->route('knowledge.index')->with('success', 'Bilan supprimé avec succès');
    }

    /**
     * Utilise l'API Gemini pour générer des QCM
     */
    private function generateQCM(array $languages, int $numQuestions)
    {
        $prompt = "Je veux générer un QCM pour évaluer des étudiants sur des langages de programmation spécifiques. Les langages à évaluer sont : " . implode(', ', $languages) . ". Crée exactement $numQuestions questions à choix multiples. Les questions doivent être directement liées aux langages de programmation fournis. La réponse doit être au format JSON uniquement, sans rien d'autre. Chaque question doit inclure les éléments suivants :\n- \"question\": la question sous forme de texte.\n- \"choices\": un tableau des choix possibles.\n- \"correct_answer\": la réponse correcte parmi les choix.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . config('services.gemini.api_key'), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        // Si la réponse est réussie, on extrait les questions générées
        if ($response->successful()) {
            $responseData = $response->json();
            $questionsJson = $responseData['candidates'][0]['content']['parts'][0]['text'];

            // Décoder le JSON pour le transformer en tableau PHP
            $questions = json_decode($questionsJson, true);

            return $questions; // Retourne les questions générées
        }

        // En cas d'échec de l'API
        return ['error' => 'Erreur lors de la génération du QCM.'];
    }
}
