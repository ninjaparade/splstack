<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CalculationData extends Data
{
    public function __construct(
        public readonly string|int $id,
        public readonly string $expression,
        public readonly int|float $result,
    ) {
    }
}
