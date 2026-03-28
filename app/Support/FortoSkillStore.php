<?php

namespace App\Support;

use App\Models\Skill;

class FortoSkillStore
{
    public function all(): array
    {
        return Skill::query()
            ->latest('created_at')
            ->get()
            ->map(fn (Skill $skill): array => $this->serialize($skill))
            ->all();
    }

    public function find(string $id): ?array
    {
        $skill = Skill::query()->find($id);

        return $skill ? $this->serialize($skill) : null;
    }

    public function create(array $attributes): array
    {
        $skill = Skill::query()->create([
            'title' => trim((string) $attributes['title']),
            'items' => $this->normalizeItems($attributes['items'] ?? ''),
        ]);

        return $this->serialize($skill);
    }

    public function delete(string $id): bool
    {
        return Skill::query()->whereKey($id)->delete() > 0;
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

    private function serialize(Skill $skill): array
    {
        return [
            'id' => (string) $skill->getKey(),
            'title' => trim((string) $skill->title),
            'items' => $this->normalizeItems($skill->items ?? []),
            'created_at' => optional($skill->created_at)?->toIso8601String() ?? now()->toIso8601String(),
            'updated_at' => optional($skill->updated_at)?->toIso8601String() ?? now()->toIso8601String(),
        ];
    }
}
