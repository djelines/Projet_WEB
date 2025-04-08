<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonLifeController extends Controller
{
    public function index() {
        return view('pages.commonLife.index');
    }

    /**
     * 
     * Je sais, j’aurais dû tout faire dans "CommonLife"… mais au final j’ai gardé "Task"
     * Je t'explique pourquoi j'ai gardé "Task" au lieu de créer un modèle "CommonLife" :
     *
     * - Réutilisation des ressources Laravel : avec `Route::resource`, j'ai directement accès aux méthodes CRUD, au nommage automatique, etc. → gain de temps.
     * - Scalabilité : je peux filtrer les tâches avec la colonne `category` (ex : vie commune), donc pas besoin de dupliquer le modèle.
     * - Souplesse : "Task" reste un modèle assez générique pour gérer différents types de tâches (vie commune, scolaire, perso).
     *
     * Je sais que j'aurais pu tout faire dans "CommonLife", mais ça me semblait plus simple comme ça.
     * Désolé Thibaud si tu vois ce message, j'espère que tu m'en voudras pas et que tu m'en tiendras pas rigueur.
     * 
     */

}
