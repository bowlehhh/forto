<?php

namespace App\Support;

use App\Models\Visitor;
use Illuminate\Support\Str;

class FortoVisitorStore
{
    public function all(): array
    {
        return Visitor::query()
            ->orderByDesc('last_visited_at')
            ->get()
            ->map(fn (Visitor $visitor): array => $this->serialize($visitor))
            ->all();
    }

    public function summary(int $limit = 5): array
    {
        $visitors = Visitor::query()
            ->orderByDesc('last_visited_at')
            ->limit($limit)
            ->get();

        return [
            'total' => Visitor::query()->count(),
            'people' => $visitors
                ->map(fn (Visitor $visitor): array => [
                    'name' => $visitor->name,
                    'initials' => $this->initials($visitor->name),
                ])
                ->all(),
        ];
    }

    public function add(string $name, string $token): array
    {
        $normalizedName = trim($name);
        $normalizedToken = trim($token);
        $adminName = trim((string) config('forto.admin.name', 'wtp'));
        $isAdmin = Str::lower($normalizedName) === Str::lower($adminName);

        if ($normalizedName === '' || $normalizedToken === '') {
            return [
                'recorded' => false,
                'is_admin' => $isAdmin,
                'visitor_name' => $normalizedName,
                'total' => Visitor::query()->count(),
            ];
        }

        if ($isAdmin) {
            return [
                'recorded' => false,
                'is_admin' => true,
                'visitor_name' => $adminName,
                'total' => Visitor::query()->count(),
            ];
        }

        $now = now();
        $visitor = Visitor::query()
            ->where('token', $normalizedToken)
            ->first();

        if ($visitor) {
            $visitor->fill([
                'name' => $normalizedName,
                'last_visited_at' => $now,
            ])->save();
        } else {
            Visitor::query()->create([
                'token' => $normalizedToken,
                'name' => $normalizedName,
                'first_visited_at' => $now,
                'last_visited_at' => $now,
            ]);
        }

        return [
            'recorded' => true,
            'is_admin' => false,
            'visitor_name' => $normalizedName,
            'total' => Visitor::query()->count(),
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

    private function serialize(Visitor $visitor): array
    {
        return [
            'id' => (string) $visitor->getKey(),
            'token' => trim((string) $visitor->token),
            'name' => trim((string) $visitor->name),
            'first_visited_at' => optional($visitor->first_visited_at)?->toIso8601String() ?? now()->toIso8601String(),
            'last_visited_at' => optional($visitor->last_visited_at)?->toIso8601String() ?? now()->toIso8601String(),
        ];
    }
}
