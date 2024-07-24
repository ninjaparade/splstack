<?php

namespace App\Http\Controllers;

use App\Data\CalculationData;
use App\Http\Requests\CalculateRequest;
use App\Services\Math\Facade\Math;

class CalculateController extends Controller
{
    public function __invoke(CalculateRequest $request)
    {
        $expression = $request->validated('calculation');

        return CalculationData::from([
            'expression' => $expression,
            'result' => Math::calculate($expression),
        ]);
    }
}
