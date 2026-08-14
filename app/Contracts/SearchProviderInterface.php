<?php

namespace App\Contracts;

interface SearchProviderInterface
{
    public function key(): string;

    public function count(string $query): int;

    public function search(string $query, int $limit, int $offset = 0): array;
}
