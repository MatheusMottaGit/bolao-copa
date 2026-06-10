<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function index(): View
    {
        $groups = Auth::user()->groups()->withCount('users')->get();

        return view('groups.index', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $group = Group::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        $group->users()->attach(Auth::id());

        return redirect()->route('groups.show', $group)->with('success', 'Bolão criado com sucesso!');
    }

    public function show(Request $request, Group $group): View
    {
        abort_unless(
            $group->users()->where('user_id', Auth::id())->exists(),
            403
        );

        $search = $request->string('search')->trim()->value();
        $games = \App\Models\Game::orderBy('starts_at')
            ->when($search, fn ($q) => $q->where(fn ($q) =>
                $q->where('home_team', 'like', "%{$search}%")
                  ->orWhere('away_team', 'like', "%{$search}%")
            ))
            ->get()
            ->groupBy(fn ($game) => $game->starts_at->format('Y-m-d'));
        $userPredictions = Auth::user()
            ->predictions()
            ->where('group_id', $group->id)
            ->get()
            ->keyBy('game_id');

        $ranking = $this->buildRanking($group);

        $members = $group->users()->orderBy('username')->get();

        $allPredictions = \App\Models\Prediction::where('group_id', $group->id)
            ->get()
            ->groupBy('game_id')
            ->map(fn ($predictions) => $predictions->keyBy('user_id'));

        return view('groups.show', compact('group', 'games', 'userPredictions', 'allPredictions', 'members', 'ranking', 'search'));
    }

    public function participants(Group $group): View
    {
        abort_unless(
            $group->users()->where('user_id', Auth::id())->exists() || Auth::user()->is_admin,
            403
        );

        $members = $group->users()->orderBy('username')->get();

        return view('groups.participants', compact('group', 'members'));
    }

    public function join(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $group = Group::where('code', strtoupper($request->code))->firstOrFail();

        if ($group->users()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Você já está neste bolão.');
        }

        $group->users()->attach(Auth::id());

        return redirect()->route('groups.show', $group)->with('success', 'Você entrou no bolão!');
    }

    private function buildRanking(Group $group): \Illuminate\Support\Collection
    {
        return $group->users()
            ->withSum(['predictions as total_points' => fn ($q) => $q->where('group_id', $group->id)], 'points')
            ->withSum(['predictions as total_bet' => fn ($q) => $q->where('group_id', $group->id)], 'bet_amount')
            ->orderByDesc('total_points')
            ->get();
    }
}
