<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RankingController extends Controller
{
    public function show(Group $group): View
    {
        abort_unless($group->users()->where('user_id', Auth::id())->exists(), 403);

        $ranking = $group->users()
            ->withSum(['predictions as total_points' => fn ($q) => $q->where('group_id', $group->id)], 'points')
            ->withCount(['predictions as exact_count' => fn ($q) => $q->where('group_id', $group->id)->where('points', 3)])
            ->orderByDesc('total_points')
            ->orderByDesc('exact_count')
            ->get();

        return view('ranking.show', compact('group', 'ranking'));
    }
}
