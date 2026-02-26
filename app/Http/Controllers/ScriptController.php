<?php

namespace App\Http\Controllers;

use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScriptController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $scripts = Script::when($userId, fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('id')
            ->get();

        return view('user.pages.scripts', compact('scripts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'content' => ['required', 'string', 'min:3'],
        ]);

        $data['user_id'] = Auth::id(); // if you want per-user scripts

        Script::create($data);

        return back()->with('success', 'Script created.');
    }

    public function update(Request $request, Script $script)
    {
        // MVP ownership check
        if ($script->user_id && $script->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:120'],
            'content' => ['required', 'string', 'min:3'],
        ]);

        $script->update($data);

        return back()->with('success', 'Script updated.');
    }

    public function destroy(Script $script)
    {
        // MVP ownership check
        if ($script->user_id && $script->user_id !== Auth::id()) {
            abort(403);
        }

        $script->delete();

        return back()->with('success', 'Script deleted.');
    }
}