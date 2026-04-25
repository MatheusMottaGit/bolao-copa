<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    public function index(): View
    {
        $groups = Group::with('owner')->withCount('users')->latest()->get();

        return view('admin.groups.index', compact('groups'));
    }

    public function create(): View
    {
        return view('admin.groups.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'owner_id' => ['required', 'exists:users,id'],
        ]);

        $group = Group::create([
            'name' => $request->name,
            'owner_id' => $request->owner_id,
        ]);

        $group->users()->attach($request->owner_id);

        return redirect()->route('admin.groups.index')->with('success', 'Bolão criado!');
    }

    public function show(Group $group): View
    {
        $group->load('users', 'owner');

        return view('admin.groups.show', compact('group'));
    }

    public function destroy(Group $group): RedirectResponse
    {
        $group->delete();

        return redirect()->route('admin.groups.index')->with('success', 'Bolão deletado.');
    }
}
