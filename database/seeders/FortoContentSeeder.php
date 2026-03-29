<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SiteLike;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FortoContentSeeder extends Seeder
{
    /**
     * Seed the application's Forto content.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            foreach (config('forto.projects', []) as $project) {
                $title = trim((string) ($project['title'] ?? 'Untitled Project'));

                if ($title === '') {
                    continue;
                }

                Project::query()->updateOrCreate(
                    ['title' => $title],
                    [
                        'category' => trim((string) ($project['category'] ?? 'Project')),
                        'summary' => trim((string) ($project['summary'] ?? '')),
                        'stack' => $this->normalizeList($project['stack'] ?? []),
                        'status' => trim((string) ($project['status'] ?? 'Draft')),
                        'github_url' => $this->normalizeGithubUrl($project['github_url'] ?? null),
                    ],
                );
            }

            foreach (config('forto.skills', []) as $skill) {
                $title = trim((string) ($skill['title'] ?? 'Skill'));

                if ($title === '') {
                    continue;
                }

                Skill::query()->updateOrCreate(
                    ['title' => $title],
                    [
                        'items' => $this->normalizeList($skill['items'] ?? []),
                    ],
                );
            }

            $seededAt = now();

            foreach (config('forto.site_like.people', []) as $name) {
                $normalizedName = trim((string) $name);

                if ($normalizedName === '') {
                    continue;
                }

                SiteLike::query()->updateOrCreate(
                    ['name' => $normalizedName],
                    ['liked_at' => $seededAt],
                );
            }
        });
    }

    private function normalizeList(array|string $items): array
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
