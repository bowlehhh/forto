<?php

namespace App\Support;

use App\Models\Visitor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class FortoVisitorStore
{
    private ?bool $storageAvailable = null;

    public function all(): array
    {
        if (! $this->storageAvailable()) {
            return [];
        }

        try {
            return Visitor::query()
                ->orderByDesc('last_visited_at')
                ->get()
                ->map(fn (Visitor $visitor): array => $this->serialize($visitor))
                ->all();
        } catch (Throwable) {
            return [];
        }
    }

    public function summary(int $limit = 5): array
    {
        if (! $this->storageAvailable()) {
            return $this->emptySummary();
        }

        try {
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
        } catch (Throwable) {
            return $this->emptySummary();
        }
    }

    public function add(string $name, string $token): array
    {
        $normalizedName = trim($name);
        $normalizedToken = trim($token);
        $adminName = trim((string) config('forto.admin.name', 'wtp'));
        $isAdmin = Str::lower($normalizedName) === Str::lower($adminName);
        $total = $this->countVisitors();

        if ($normalizedName === '' || $normalizedToken === '') {
            return [
                'recorded' => false,
                'is_admin' => $isAdmin,
                'visitor_name' => $normalizedName,
                'total' => $total,
            ];
        }

        if ($isAdmin) {
            return [
                'recorded' => false,
                'is_admin' => true,
                'visitor_name' => $adminName,
                'total' => $total,
            ];
        }

        if (! $this->storageAvailable()) {
            return [
                'recorded' => false,
                'is_admin' => false,
                'visitor_name' => $normalizedName,
                'total' => $total,
            ];
        }

        $now = now();

        try {
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
                'total' => $this->countVisitors(),
            ];
        } catch (Throwable) {
            return [
                'recorded' => false,
                'is_admin' => false,
                'visitor_name' => $normalizedName,
                'total' => $total,
            ];
        }
    }

    private function storageAvailable(): bool
    {
        if ($this->storageAvailable !== null) {
            return $this->storageAvailable;
        }

        try {
            return $this->storageAvailable = Schema::hasTable('visitors');
        } catch (Throwable) {
            return $this->storageAvailable = false;
        }
    }

    private function countVisitors(): int
    {
        if (! $this->storageAvailable()) {
            return 0;
        }

        try {
            return Visitor::query()->count();
        } catch (Throwable) {
            return 0;
        }
    }

    private function emptySummary(): array
    {
        return [
            'total' => 0,
            'people' => [],
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
