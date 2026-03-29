<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardProjectController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        Project::query()->create($this->validatedData($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project ditambahkan')
            ->with('status_type', 'success')
            ->with('status', 'Project baru berhasil disimpan ke database.');
    }

    public function edit(Project $project): View
    {
        return view('pages.project-edit', [
            'pageTitle' => 'Edit Project',
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $project->update($this->validatedData($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project diperbarui')
            ->with('status_type', 'success')
            ->with('status', 'Perubahan project berhasil disimpan.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $title = $project->title;
        $project->delete();

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project dihapus')
            ->with('status_type', 'info')
            ->with('status', "Project {$title} berhasil dihapus.");
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validateWithBag('projectForm', [
            'title' => ['required', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:120'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'stack' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'string', 'max:80'],
            'github_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        return [
            'title' => trim((string) $validated['title']),
            'category' => $this->normalizeText($validated['category'] ?? '', 'Project'),
            'summary' => trim((string) ($validated['summary'] ?? '')),
            'stack' => $this->normalizeList((string) ($validated['stack'] ?? '')),
            'status' => $this->normalizeText($validated['status'] ?? '', 'Ready'),
            'github_url' => $this->normalizeGithubUrl($validated['github_url'] ?? ''),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];
    }

    private function normalizeText(mixed $value, string $fallback): string
    {
        $normalized = trim((string) $value);

        return $normalized !== '' ? $normalized : $fallback;
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

    private function normalizeGithubUrl(mixed $url): ?string
    {
        $normalized = trim((string) $url);

        if ($normalized === '') {
            return null;
        }

        if (! preg_match('/^https?:\/\//i', $normalized)) {
            $normalized = 'https://' . $normalized;
        }

        return $normalized;
    }
}
