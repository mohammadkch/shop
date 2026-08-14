<?php

namespace App\Services;

use App\Contracts\SearchProviderInterface;

class SearchService
{
    /** @var SearchProviderInterface[] */
    private array $providers;

    public function __construct(array $providers = [])
    {
        $this->providers = $providers;
    }

    public function normalizeQuery($query): string
    {
        if (!is_scalar($query) && $query !== null) {
            return '';
        }

        $query = str_replace(['ي', 'ى', 'ك'], ['ی', 'ی', 'ک'], (string) $query);
        $query = preg_replace('/\s+/u', ' ', trim($query));

        return mb_substr($query ?? '', 0, 100);
    }

    public function search(?string $query, int $limit = 12, int $offset = 0): array
    {
        $query = $this->normalizeQuery($query);
        if (mb_strlen($query) < 2) {
            return ['query' => $query, 'items' => [], 'total' => 0];
        }

        $offset = max(0, $offset);
        $limit = max(1, min($limit, 50));
        $providerTotals = [];
        $providerPositions = [];
        $selectedPositions = [];
        $sequence = [];

        foreach ($this->providers as $index => $provider) {
            $providerTotals[$index] = $provider->count($query);
            $providerPositions[$index] = 0;
            $selectedPositions[$index] = [];
        }

        $total = array_sum($providerTotals);
        $end = min($total, $offset + $limit);
        while (count($sequence) < $end) {
            $added = false;
            foreach ($this->providers as $index => $provider) {
                if ($providerPositions[$index] >= $providerTotals[$index] || count($sequence) >= $end) {
                    continue;
                }

                $position = $providerPositions[$index]++;
                if (count($sequence) >= $offset) {
                    $selectedPositions[$index][] = $position;
                    $sequence[] = $index;
                } else {
                    $sequence[] = null;
                }
                $added = true;
            }
            if (!$added) {
                break;
            }
        }

        $providerItems = [];
        foreach ($this->providers as $index => $provider) {
            if (empty($selectedPositions[$index])) {
                continue;
            }
            $start = min($selectedPositions[$index]);
            $providerItems[$index] = $provider->search($query, count($selectedPositions[$index]), $start);
        }

        $items = [];
        foreach (array_slice($sequence, $offset) as $providerIndex) {
            if ($providerIndex !== null && !empty($providerItems[$providerIndex])) {
                $items[] = array_shift($providerItems[$providerIndex]);
            }
        }

        return ['query' => $query, 'items' => $items, 'total' => $total];
    }

    public function suggestions($query, int $limit = 6): array
    {
        $query = $this->normalizeQuery($query);
        if (mb_strlen($query) < 2) {
            return ['query' => $query, 'items' => [], 'total' => 0];
        }

        $limits = ['product' => 4, 'article' => 2, 'category' => 2];
        $items = [];
        $total = 0;

        foreach ($this->providers as $provider) {
            $total += $provider->count($query);
            $providerLimit = $limits[$provider->key()] ?? max(1, min($limit, 10));
            $items = array_merge($items, $provider->search($query, $providerLimit));
        }

        return ['query' => $query, 'items' => $items, 'total' => $total];
    }

    public function searchType($query, string $type, int $limit = 12, int $offset = 0): array
    {
        $query = $this->normalizeQuery($query);
        if (mb_strlen($query) < 2) {
            return ['query' => $query, 'items' => [], 'total' => 0];
        }

        foreach ($this->providers as $provider) {
            if ($provider->key() !== $type) {
                continue;
            }

            return [
                'query' => $query,
                'items' => $provider->search($query, max(1, min($limit, 50)), max(0, $offset)),
                'total' => $provider->count($query),
            ];
        }

        return ['query' => $query, 'items' => [], 'total' => 0];
    }
}
