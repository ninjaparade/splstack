<?php

namespace App\Http\Controllers;

use App\Data\CalculationData;
use App\Http\Requests\CalculateRequest;
use App\Models\Calculation;
use App\Services\Math\Facade\Math;

class CalculateController extends Controller
{
    public function __invoke(CalculateRequest $request)
    {
        $expression = $request->validated('calculation');

        $response = CalculationData::from([
            'expression' => $expression,
            'result' => Math::calculate($expression),
        ]);

        Calculation::create($response->toArray());

        return $response;
    }
}
