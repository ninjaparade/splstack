<?php

namespace Tests\Unit\Services\Math\Facade;

use App\Services\Math\Facade\Math;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\TestCase;

class MathTest extends TestCase
{
    #[DataProviderExternal(ExternalDataProvider::class, 'mathExpressions')]
    public function testAdd(string $expression, int|float $expected): void
    {
        $result = Math::calculate($expression);

        $this->assertSame($expected, $result);
    }
}

final class ExternalDataProvider
{
    public static function mathExpressions(): array
    {
        return [

            ['(5+5)', 10.0],
            ['5+5', 10.0],
            ['((5+5)* 2)', 20.0],
            ['((5+5)* 4)', 40.0],
            ['((5*5)* 4)', 100.0],
            ['((5*5) / 5)', 5.0],
            ['(((5*5) / 5) + (5+5))', 15.0],
            ['(((5*5) / 5) * (5+5))', 50.0],
            ['(((5*5) / 5) * (5+5)/ 5)', 10.0],
            ['(((1*5) / 5) * (5+5)/ 5)', 2.0],
            ['5-5', 0.0],
            ['(5-5)', 0.0],
            ['(5-50)', -45.0],
            ['((5-50)* -1)', 45.0],
        ];
    }
}
