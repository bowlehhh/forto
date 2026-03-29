<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'pageTitle' => 'Home',
            'bodyClass' => 'home-page',
            'highlights' => config('forto.highlights'),
            'owner' => config('forto.owner'),
            'siteLikeSummary' => $this->siteLikeSummary(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'pageTitle' => 'About',
            'about' => config('forto.about'),
            'siteLikeSummary' => $this->siteLikeSummary(),
            'galleryPhotos' => collect(range(1, 18))
                ->map(fn (int $index) => [
                    'src' => asset("img/foto{$index}.jpeg"),
                    'alt' => "Album Porto {$index}",
                    'caption' => 'Porto Moment ' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                ])
                ->all(),
        ]);
    }

    public function projects(): View
    {
        return view('pages.projects', [
            'pageTitle' => 'Projects',
            'projects' => $this->publicProjects(),
            'siteLikeSummary' => $this->siteLikeSummary(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'pageTitle' => 'Contact',
            'contact' => config('forto.contact'),
            'siteLikeSummary' => $this->siteLikeSummary(),
        ]);
    }

    public function skills(): View
    {
        return view('pages.skills', [
            'pageTitle' => 'Skills',
            'skills' => $this->publicSkills(),
            'siteLikeSummary' => $this->siteLikeSummary(),
        ]);
    }

    public function community(): View
    {
        return view('pages.community', [
            'pageTitle' => 'Community',
            'siteLikeSummary' => $this->siteLikeSummary(),
        ]);
    }

    public function dashboard(): View
    {
        return view('pages.dashboard', [
            'pageTitle' => 'Dashboard',
            'projects' => $this->publicProjects(),
            'skills' => $this->publicSkills(),
            'admin' => request()->session()->get('forto_admin'),
        ]);
    }

    private function publicProjects(): array
    {
        return collect(config('forto.projects', []))
            ->map(fn (array $project): array => [
                'title' => trim((string) Arr::get($project, 'title', 'Untitled Project')),
                'category' => trim((string) Arr::get($project, 'category', 'Project')),
                'summary' => trim((string) Arr::get($project, 'summary', '')),
                'stack' => $this->normalizeItems(Arr::get($project, 'stack', [])),
                'status' => trim((string) Arr::get($project, 'status', 'Ready')),
                'github_url' => $this->normalizeGithubUrl(Arr::get($project, 'github_url')),
            ])
            ->filter(fn (array $project): bool => $project['title'] !== '')
            ->values()
            ->all();
    }

    private function publicSkills(): array
    {
        return collect(config('forto.skills', []))
            ->map(fn (array $skill): array => [
                'title' => trim((string) Arr::get($skill, 'title', 'Skill')),
                'items' => $this->normalizeItems(Arr::get($skill, 'items', [])),
            ])
            ->filter(fn (array $skill): bool => $skill['title'] !== '')
            ->values()
            ->all();
    }

    private function siteLikeSummary(): array
    {
        return [
            'total' => max(0, (int) config('forto.site_like.default_total', 0)),
        ];
    }

    private function normalizeItems(array|string $items): array
    {
        $source = is_array($items)
            ? $items
            : (preg_split('/[,\\n]+/', (string) $items) ?: []);

        $normalized = array_map(
            fn ($item): string => trim((string) $item),
            $source,
        );

        return array_values(array_unique(array_filter($normalized)));
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
