<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FortoSiteLikeStore
{
    private const DISK = 'local';
    private const PATH = 'forto/site-likes.json';

    public function all(): array
    {
        return array_map(
            fn (array $like): array => [
                ...$like,
                'initials' => $this->initials($like['name']),
            ],
            $this->read(),
        );
    }

    public function summary(int $limit = 5): array
    {
        $likes = $this->all();

        return [
            'total' => count($likes),
            'people' => array_map(
                fn (array $like): array => [
                    'name' => $like['name'],
                    'initials' => $this->initials($like['name']),
                ],
                array_slice($likes, 0, $limit),
            ),
        ];
    }

    public function add(string $name): array
    {
        $likes = $this->read();
        $normalizedName = trim($name);

        if ($normalizedName === '') {
            return $this->summary();
        }

        $exists = collect($likes)->contains(
            fn (array $like): bool => Str::lower($like['name']) === Str::lower($normalizedName),
        );

        if (! $exists) {
            array_unshift($likes, [
                'id' => (string) Str::uuid(),
                'name' => $normalizedName,
                'liked_at' => now()->toIso8601String(),
            ]);

            $this->write($likes);
        }

        return $this->summary();
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
            fn (array $like): array => $this->normalizeLike($like),
            array_filter($decoded, 'is_array'),
        ));

        if ($normalized !== $decoded) {
            $this->write($normalized);
        }

        return $normalized;
    }

    private function write(array $likes): void
    {
        Storage::disk(self::DISK)->put(
            self::PATH,
            json_encode(array_values($likes), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function seed(): array
    {
        $now = now()->toIso8601String();

        return array_map(
            fn (string $name): array => [
                'id' => (string) Str::uuid(),
                'name' => $name,
                'liked_at' => $now,
            ],
            config('forto.site_like.people', []),
        );
    }

    private function normalizeLike(array $like): array
    {
        $now = now()->toIso8601String();

        return [
            'id' => (string) ($like['id'] ?? Str::uuid()),
            'name' => trim((string) ($like['name'] ?? 'Pengunjung')),
            'liked_at' => (string) ($like['liked_at'] ?? $now),
        ];
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
}
