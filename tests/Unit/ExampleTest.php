<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function stringProvider(): array
    {
        return [
            'all caps' => ['LARAVEL', 'laravel'],
            'mixed case' => ['lArAvEl', 'laravel'],
        ];
    }

    #[DataProvider('stringProvider')]
    public function test_it_can_lowercase_strings(string $original, string $expected): void
    {
        $this->assertSame($expected, strtolower($original));
    }
}
