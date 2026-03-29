<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardSkillController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        Skill::query()->create($this->validatedData($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Skill ditambahkan')
            ->with('status_type', 'success')
            ->with('status', 'Skill baru berhasil disimpan ke database.');
    }

    public function edit(Skill $skill): View
    {
        return view('pages.skill-edit', [
            'pageTitle' => 'Edit Skill',
            'skill' => $skill,
        ]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $skill->update($this->validatedData($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Skill diperbarui')
            ->with('status_type', 'success')
            ->with('status', 'Perubahan skill berhasil disimpan.');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $title = $skill->title;
        $skill->delete();

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Skill dihapus')
            ->with('status_type', 'info')
            ->with('status', "Skill {$title} berhasil dihapus.");
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validateWithBag('skillForm', [
            'title' => ['required', 'string', 'max:120'],
            'items' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        return [
            'title' => trim((string) $validated['title']),
            'items' => $this->normalizeList((string) ($validated['items'] ?? '')),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];
    }

    private function normalizeList(string $value): string
    {
        $items = preg_split('/[\r\n,]+/', $value) ?: [];

        $normalized = array_values(array_unique(array_filter(array_map(
            fn ($item): string => trim((string) $item),
            $items,
        ))));

        return implode("\n", $normalized);
    }
}
