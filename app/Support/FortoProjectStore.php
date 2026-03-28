<?php

namespace App\Support;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;

class FortoProjectStore
{
    public function all(): array
    {
        return $this->query()
            ->get()
            ->map(fn (Project $project): array => $this->serialize($project))
            ->all();
    }

    public function find(string $id): ?array
    {
        $project = $this->query()->find($id);

        return $project ? $this->serialize($project) : null;
    }

    public function create(array $attributes): array
    {
        $project = Project::query()->create([
            'title' => trim((string) $attributes['title']),
            'category' => trim((string) $attributes['category']),
            'summary' => trim((string) $attributes['summary']),
            'stack' => $this->normalizeStack($attributes['stack'] ?? ''),
            'status' => trim((string) $attributes['status']),
            'github_url' => $this->normalizeGithubUrl($attributes['github_url'] ?? null),
        ]);

        return $this->serialize($project);
    }

    public function update(string $id, array $attributes): ?array
    {
        $project = Project::query()->find($id);

        if (! $project) {
            return null;
        }

        $project->fill([
            'title' => trim((string) $attributes['title']),
            'category' => trim((string) $attributes['category']),
            'summary' => trim((string) $attributes['summary']),
            'stack' => $this->normalizeStack($attributes['stack'] ?? ''),
            'status' => trim((string) $attributes['status']),
            'github_url' => $this->normalizeGithubUrl($attributes['github_url'] ?? null),
        ])->save();

        return $this->serialize($project->fresh());
    }

    public function delete(string $id): bool
    {
        return Project::query()->whereKey($id)->delete() > 0;
    }

    private function normalizeStack(array|string $stack): array
    {
        $items = is_array($stack)
            ? $stack
            : (preg_split('/[,\\n]+/', (string) $stack) ?: []);

        $normalized = array_map(
            fn ($item): string => trim((string) $item),
            $items,
        );

        return array_values(array_unique(array_filter($normalized)));
    }

    private function normalizeGithubUrl(?string $url): ?string
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

    private function query(): Builder
    {
        return Project::query()->latest('created_at');
    }

    private function serialize(Project $project): array
    {
        return [
            'id' => (string) $project->getKey(),
            'title' => trim((string) $project->title),
            'category' => trim((string) $project->category),
            'summary' => trim((string) $project->summary),
            'stack' => $this->normalizeStack($project->stack ?? []),
            'status' => trim((string) $project->status),
            'github_url' => $this->normalizeGithubUrl($project->github_url),
            'created_at' => optional($project->created_at)?->toIso8601String() ?? now()->toIso8601String(),
            'updated_at' => optional($project->updated_at)?->toIso8601String() ?? now()->toIso8601String(),
        ];
    }
}
