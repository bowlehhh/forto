<?php

namespace App\Http\Controllers;

use App\Support\FortoProjectStore;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardProjectController extends Controller
{
    public function edit(string $projectId, FortoProjectStore $projectStore): View
    {
        $project = $projectStore->find($projectId);

        abort_unless($project, 404);

        return view('pages.project-edit', [
            'pageTitle' => 'Edit Project',
            'project' => $project,
        ]);
    }

    public function store(Request $request, FortoProjectStore $projectStore): RedirectResponse
    {
        $project = $projectStore->create($this->validatedProject($request));

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project dipublikasikan')
            ->with('status_type', 'success')
            ->with('status', sprintf(
                '"%s" berhasil ditambahkan dan sekarang sudah muncul di halaman public.',
                $project['title'],
            ));
    }

    public function update(Request $request, string $projectId, FortoProjectStore $projectStore): RedirectResponse
    {
        $project = $projectStore->update($projectId, $this->validatedProject($request));

        abort_unless($project, 404);

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project diperbarui')
            ->with('status_type', 'success')
            ->with('status', sprintf(
                '"%s" berhasil diperbarui dan halaman public sudah ikut ter-update.',
                $project['title'],
            ));
    }

    public function destroy(string $projectId, FortoProjectStore $projectStore): RedirectResponse
    {
        $project = $projectStore->find($projectId);

        abort_unless($project, 404);

        $projectStore->delete($projectId);

        return redirect()
            ->route('dashboard')
            ->with('status_title', 'Project dihapus')
            ->with('status_type', 'success')
            ->with('status', sprintf(
                '"%s" berhasil dihapus dari dashboard dan halaman public.',
                $project['title'],
            ));
    }

    private function validatedProject(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'summary' => ['required', 'string', 'max:700'],
            'stack' => ['nullable', 'string', 'max:220'],
            'status' => ['required', 'string', 'max:40'],
            'github_url' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
