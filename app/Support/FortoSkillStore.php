<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FortoSkillStore
{
    private const DISK = 'local';
    private const PATH = 'forto/skills.json';

    public function all(): array
    {
        return $this->read();
    }

    public function find(string $id): ?array
    {
        foreach ($this->read() as $skill) {
            if (($skill['id'] ?? null) === $id) {
                return $skill;
            }
        }

        return null;
    }

    public function create(array $attributes): array
    {
        $skills = $this->read();
        $now = now()->toIso8601String();

        $skill = [
            'id' => (string) Str::uuid(),
            'title' => trim((string) $attributes['title']),
            'items' => $this->normalizeItems($attributes['items'] ?? ''),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        array_unshift($skills, $skill);
        $this->write($skills);

        return $skill;
    }

    public function delete(string $id): bool
    {
        $skills = $this->read();
        $filtered = array_values(array_filter(
            $skills,
            fn (array $skill): bool => ($skill['id'] ?? null) !== $id,
        ));

        if (count($filtered) === count($skills)) {
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
            fn (array $skill): array => $this->normalizeSkill($skill),
            array_filter($decoded, 'is_array'),
        ));

        if ($normalized !== $decoded) {
            $this->write($normalized);
        }

        return $normalized;
    }

    private function write(array $skills): void
    {
        Storage::disk(self::DISK)->put(
            self::PATH,
            json_encode(array_values($skills), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function seed(): array
    {
        $now = now()->toIso8601String();

        return array_map(function (array $skill) use ($now): array {
            return [
                'id' => (string) Str::uuid(),
                'title' => trim((string) ($skill['title'] ?? 'Skill')),
                'items' => $this->normalizeItems($skill['items'] ?? []),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, config('forto.skills', []));
    }

    private function normalizeSkill(array $skill): array
    {
        $now = now()->toIso8601String();

        return [
            'id' => (string) ($skill['id'] ?? Str::uuid()),
            'title' => trim((string) ($skill['title'] ?? 'Skill')),
            'items' => $this->normalizeItems($skill['items'] ?? []),
            'created_at' => (string) ($skill['created_at'] ?? $now),
            'updated_at' => (string) ($skill['updated_at'] ?? $now),
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
}
