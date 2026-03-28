<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FortoProjectStore
{
    private const DISK = 'local';
    private const PATH = 'forto/projects.json';

    public function all(): array
    {
        return $this->read();
    }

    public function find(string $id): ?array
    {
        foreach ($this->read() as $project) {
            if (($project['id'] ?? null) === $id) {
                return $project;
            }
        }

        return null;
    }

    public function create(array $attributes): array
    {
        $projects = $this->read();
        $now = now()->toIso8601String();

        $project = [
            'id' => (string) Str::uuid(),
            'title' => $attributes['title'],
            'category' => $attributes['category'],
            'summary' => $attributes['summary'],
            'stack' => $this->normalizeStack($attributes['stack'] ?? ''),
            'status' => $attributes['status'],
            'github_url' => $this->normalizeGithubUrl($attributes['github_url'] ?? null),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        array_unshift($projects, $project);

        $this->write($projects);

        return $project;
    }

    public function update(string $id, array $attributes): ?array
    {
        $projects = $this->read();

        foreach ($projects as $index => $project) {
            if (($project['id'] ?? null) !== $id) {
                continue;
            }

            $projects[$index] = [
                ...$project,
                'title' => $attributes['title'],
                'category' => $attributes['category'],
                'summary' => $attributes['summary'],
                'stack' => $this->normalizeStack($attributes['stack'] ?? ''),
                'status' => $attributes['status'],
                'github_url' => $this->normalizeGithubUrl($attributes['github_url'] ?? null),
                'updated_at' => now()->toIso8601String(),
            ];

            $this->write($projects);

            return $projects[$index];
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $projects = $this->read();
        $filtered = array_values(array_filter(
            $projects,
            fn (array $project): bool => ($project['id'] ?? null) !== $id,
        ));

        if (count($filtered) === count($projects)) {
            return false;
        }

        $this->write($filtered);

        return true;
    }

    private function read(): array
    {
        $disk = Storage::disk(self::DISK);

        if (! $disk->exists(self::PATH)) {
            $seeded = $this->seed();
            $this->write($seeded);

            return $seeded;
        }

        $decoded = json_decode((string) $disk->get(self::PATH), true);

        if (! is_array($decoded)) {
            $seeded = $this->seed();
            $this->write($seeded);

            return $seeded;
        }

        $normalized = array_values(array_map(
            fn (array $project): array => $this->normalizeProject($project),
            array_filter($decoded, 'is_array'),
        ));

        if ($normalized !== $decoded) {
            $this->write($normalized);
        }

        return $normalized;
    }

    private function write(array $projects): void
    {
        Storage::disk(self::DISK)->put(
            self::PATH,
            json_encode(array_values($projects), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function seed(): array
    {
        $now = now()->toIso8601String();

        return array_map(function (array $project) use ($now): array {
            return [
                'id' => (string) Str::uuid(),
                'title' => (string) ($project['title'] ?? 'Untitled Project'),
                'category' => (string) ($project['category'] ?? 'Project'),
                'summary' => (string) ($project['summary'] ?? ''),
                'stack' => $this->normalizeStack($project['stack'] ?? []),
                'status' => (string) ($project['status'] ?? 'Draft'),
                'github_url' => $this->normalizeGithubUrl($project['github_url'] ?? null),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, config('forto.projects', []));
    }

    private function normalizeProject(array $project): array
    {
        $now = now()->toIso8601String();

        return [
            'id' => (string) ($project['id'] ?? Str::uuid()),
            'title' => trim((string) ($project['title'] ?? 'Untitled Project')),
            'category' => trim((string) ($project['category'] ?? 'Project')),
            'summary' => trim((string) ($project['summary'] ?? '')),
            'stack' => $this->normalizeStack($project['stack'] ?? []),
            'status' => trim((string) ($project['status'] ?? 'Draft')),
            'github_url' => $this->normalizeGithubUrl($project['github_url'] ?? null),
            'created_at' => (string) ($project['created_at'] ?? $now),
            'updated_at' => (string) ($project['updated_at'] ?? $now),
        ];
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
}
