<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Group;
use App\Models\Prediction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PredictionController extends Controller
{
    public function store(Request $request, Group $group, Game $game): RedirectResponse
    {
        abort_unless($group->users()->where('user_id', Auth::id())->exists(), 403);
        abort_unless($game->isOpen(), 403, 'O jogo já começou.');

        $request->validate([
            'home_score' => ['required', 'integer', 'min:0'],
            'away_score' => ['required', 'integer', 'min:0'],
        ], [
            'home_score.required' => 'Informe o placar do time da casa.',
            'home_score.integer'  => 'O placar deve ser um número inteiro.',
            'home_score.min'      => 'O placar não pode ser negativo.',
            'away_score.required' => 'Informe o placar do time visitante.',
            'away_score.integer'  => 'O placar deve ser um número inteiro.',
            'away_score.min'      => 'O placar não pode ser negativo.',
        ]);

        Prediction::updateOrCreate(
            ['user_id' => Auth::id(), 'game_id' => $game->id, 'group_id' => $group->id],
            [
                'home_score' => $request->home_score,
                'away_score' => $request->away_score,
            ]
        );

        return back()->with('success', 'Palpite salvo!');
    }
}
