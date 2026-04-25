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

        $minBet = (float) $group->current_min_bet;

        $request->validate([
            'home_score' => ['required', 'integer', 'min:0'],
            'away_score' => ['required', 'integer', 'min:0'],
            'bet_amount' => [
                'nullable',
                'numeric',
                'min:' . $minBet,
            ],
        ]);

        $prediction = Prediction::updateOrCreate(
            ['user_id' => Auth::id(), 'game_id' => $game->id, 'group_id' => $group->id],
            [
                'home_score' => $request->home_score,
                'away_score' => $request->away_score,
                'bet_amount' => $request->bet_amount,
            ]
        );

        if ($request->filled('bet_amount') && (float) $request->bet_amount > $minBet) {
            $group->update(['current_min_bet' => $request->bet_amount]);
        }

        return back()->with('success', 'Palpite salvo!');
    }
}
