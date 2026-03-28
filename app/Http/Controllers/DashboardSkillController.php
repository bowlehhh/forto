<?php

namespace App\Http\Controllers;

use App\Support\FortoSkillStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardSkillController extends Controller
{
    public function store(Request $request, FortoSkillStore $skillStore): RedirectResponse
    {
        $skill = $skillStore->create($this->validatedSkill($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Skill ditambahkan')
            ->with('status_type', 'success')
            ->with('status', sprintf(
                '"%s" berhasil ditambahkan ke halaman Skill.',
                $skill['title'],
            ));
    }

    public function destroy(string $skillId, FortoSkillStore $skillStore): RedirectResponse
    {
        $skill = $skillStore->find($skillId);

        abort_unless($skill, 404);

        $skillStore->delete($skillId);

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Skill dihapus')
            ->with('status_type', 'success')
            ->with('status', sprintf(
                '"%s" berhasil dihapus dari halaman Skill.',
                $skill['title'],
            ));
    }

    private function validatedSkill(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'items' => ['nullable', 'string', 'max:320'],
        ]);
    }
}
