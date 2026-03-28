<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FortoVisitorStore
{
    private const DISK = 'local';
    private const PATH = 'forto/visitors.json';

    public function all(): array
    {
        return $this->read();
    }

    public function summary(int $limit = 5): array
    {
        $visitors = $this->read();

        return [
            'total' => count($visitors),
            'people' => array_map(
                fn (array $visitor): array => [
                    'name' => $visitor['name'],
                    'initials' => $this->initials($visitor['name']),
                ],
                array_slice($visitors, 0, $limit),
            ),
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
                'total' => count($this->read()),
            ];
        }

        if ($isAdmin) {
            return [
                'recorded' => false,
                'is_admin' => true,
                'visitor_name' => $adminName,
                'total' => count($this->read()),
            ];
        }

        $visitors = $this->read();
        $now = now()->toIso8601String();
        $existingIndex = collect($visitors)->search(
            fn (array $visitor): bool => ($visitor['token'] ?? null) === $normalizedToken,
        );

        if ($existingIndex !== false) {
            $existing = $visitors[$existingIndex];
            unset($visitors[$existingIndex]);

            array_unshift($visitors, [
                ...$existing,
                'name' => $normalizedName,
                'last_visited_at' => $now,
            ]);
        } else {
            array_unshift($visitors, [
                'id' => (string) Str::uuid(),
                'token' => $normalizedToken,
                'name' => $normalizedName,
                'first_visited_at' => $now,
                'last_visited_at' => $now,
            ]);
        }

        $this->write($visitors);

        return [
            'recorded' => true,
            'is_admin' => false,
            'visitor_name' => $normalizedName,
            'total' => count($visitors),
        ];
    }

    private function read(): array
    {
        $disk = Storage::disk(self::DISK);

        if (! $disk->exists(self::PATH)) {
            $this->write([]);

            return [];
        }

        $decoded = json_decode((string) $disk->get(self::PATH), true);

        if (! is_array($decoded)) {
            $this->write([]);

            return [];
        }

        $normalized = array_values(array_map(
            fn (array $visitor): array => $this->normalizeVisitor($visitor),
            array_filter($decoded, 'is_array'),
        ));

        if ($normalized !== $decoded) {
            $this->write($normalized);
        }

        return $normalized;
    }

    private function write(array $visitors): void
    {
        Storage::disk(self::DISK)->put(
            self::PATH,
            json_encode(array_values($visitors), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        );
    }

    private function normalizeVisitor(array $visitor): array
    {
        $now = now()->toIso8601String();

        return [
            'id' => (string) ($visitor['id'] ?? Str::uuid()),
            'token' => trim((string) ($visitor['token'] ?? Str::uuid())),
            'name' => trim((string) ($visitor['name'] ?? 'Pengunjung')),
            'first_visited_at' => (string) ($visitor['first_visited_at'] ?? $now),
            'last_visited_at' => (string) ($visitor['last_visited_at'] ?? ($visitor['first_visited_at'] ?? $now)),
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
