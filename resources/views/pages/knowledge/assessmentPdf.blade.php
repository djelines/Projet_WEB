<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport d'Évaluation des Compétences</title>
    <style>
        @page {
            margin: 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #003e6b;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .logo {
            height: 60px;
        }

        .school-info {
            text-align: right;
            font-size: 13px;
            color: #003e6b;
        }

        h1 {
            text-align: center;
            color: #003e6b;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 5px;
            color: #666;
        }

        .meta-info {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
            color: #888;
        }

        .introduction {
            font-size: 11.5px;
            margin-bottom: 30px;
            text-align: justify;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th {
            background-color: #003e6b;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f5f9fc;
        }

        footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('images/logo-esiee.png') }}" class="logo" alt="Logo ESIEE-IT">
    <div class="school-info">
        ESIEE-IT<br>
        Département Informatique Numérique<br>
        www.esiee-it.fr
    </div>
</header>

<h1>Rapport d'Évaluation des Compétences</h1>
<div class="subtitle">
    Session : {{ $assessment->id ?? 'Bilan de compétences' }}
</div>
@php
    $moyenne = $results->count() > 0
        ? number_format($results->sum(function ($r) use ($assessment) {
            return ($r->score / $assessment->num_questions) * 20;
        }) / $results->count(), 2)
        : 'N/A';
@endphp
<div class="meta-info">
    Langages évalués : {{ implode(', ', $assessment->languages ?? []) }}<br>
    Nombre de questions : {{ $assessment->num_questions ?? " " }} <br>
    Moyenne de classe : <strong>{{ $moyenne }} / 20</strong>
</div>


<table>
    <thead>
        <tr>
            <th>Étudiant(e)</th>
            <th>Date de passation</th>
            <th>Résultat obtenu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $result->user->first_name }} {{ $result->user->last_name }}</td>
                <td>{{ $result->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ number_format(($result->score  / $assessment->num_questions) * 20, 2) }} / 20</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="introduction">
    L’ensemble des résultats obtenus témoigne de l’investissement des étudiantes et constitue une base de réflexion pédagogique pour l’adaptation continue des parcours de montée en compétences.
    <br><br>
    Ce rapport peut être annexé à un dossier de suivi de parcours, à une évaluation semestrielle ou à une restitution pédagogique dans un cadre d’amélioration continue ou de pilotage pédagogique.
</div>

<footer>
    Rapport généré automatiquement le {{ now()->format('d/m/Y à H:i') }} – Plateforme CodingToolBox – Usage interne ESIEE-IT
</footer>

</body>
</html>
