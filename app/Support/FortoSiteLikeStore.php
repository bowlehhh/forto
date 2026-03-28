<?php

namespace App\Support;

use App\Models\SiteLike;
use Illuminate\Support\Str;

class FortoSiteLikeStore
{
    public function all(): array
    {
        return SiteLike::query()
            ->orderByDesc('liked_at')
            ->get()
            ->map(fn (SiteLike $like): array => $this->serialize($like))
            ->all();
    }

    public function summary(int $limit = 5): array
    {
        $likes = SiteLike::query()
            ->orderByDesc('liked_at')
            ->limit($limit)
            ->get();

        return [
            'total' => SiteLike::query()->count(),
            'people' => $likes
                ->map(fn (SiteLike $like): array => [
                    'name' => $like->name,
                    'initials' => $this->initials($like->name),
                ])
                ->all(),
        ];
    }

    public function add(string $name): array
    {
        $normalizedName = trim($name);

        if ($normalizedName === '') {
            return $this->summary();
        }

        $existing = SiteLike::query()
            ->whereRaw('LOWER(name) = ?', [Str::lower($normalizedName)])
            ->first();

        if (! $existing) {
            SiteLike::query()->create([
                'name' => $normalizedName,
                'liked_at' => now(),
            ]);
        }

        return $this->summary();
    }

    private function initials(string $name): string
    {
        return Str::of($name)
            ->trim()
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');
    }

    private function serialize(SiteLike $like): array
    {
        return [
            'id' => (string) $like->getKey(),
            'name' => trim((string) $like->name),
            'liked_at' => optional($like->liked_at)?->toIso8601String() ?? now()->toIso8601String(),
            'initials' => $this->initials($like->name),
        ];
    }
}
