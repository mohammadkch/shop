<?php

namespace Tests\Unit;

use App\Contracts\SearchProviderInterface;
use App\Services\SearchService;
use PHPUnit\Framework\TestCase;

final class SearchServiceTest extends TestCase
{
    public function testNormalizesPersianQueryAndRejectsArrays(): void
    {
        $service = new SearchService();

        self::assertSame('کیف یاسی', $service->normalizeQuery('  كيف   ياسي  '));
        self::assertSame('', $service->normalizeQuery(['invalid']));
    }

    public function testReturnsTheStandardProviderResult(): void
    {
        $provider = new class implements SearchProviderInterface {
            public function key(): string
            {
                return 'product';
            }

            public function count(string $query): int
            {
                return 1;
            }

            public function search(string $query, int $limit, int $offset = 0): array
            {
                return [['type' => $this->key(), 'title' => $query]];
            }
        };

        $result = (new SearchService([$provider]))->searchType('کت', 'product', 6);

        self::assertSame(1, $result['total']);
        self::assertSame('product', $result['items'][0]['type']);
        self::assertSame('کت', $result['items'][0]['title']);
    }

    public function testInterleavesMultipleProviders(): void
    {
        $provider = static function (string $type): SearchProviderInterface {
            return new class($type) implements SearchProviderInterface {
                public function __construct(private string $type)
                {
                }

                public function key(): string
                {
                    return $this->type;
                }

                public function count(string $query): int
                {
                    return 2;
                }

                public function search(string $query, int $limit, int $offset = 0): array
                {
                    $items = [];
                    for ($index = $offset; $index < $offset + $limit; $index++) {
                        $items[] = ['type' => $this->type, 'title' => $this->type . $index];
                    }
                    return $items;
                }
            };
        };

        $result = (new SearchService([
            $provider('product'),
            $provider('category'),
            $provider('article'),
        ]))->search('کت', 6);

        self::assertSame(
            ['product', 'category', 'article', 'product', 'category', 'article'],
            array_column($result['items'], 'type')
        );
    }
}
