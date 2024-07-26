<?php

namespace App\Http\Controllers;

use App\Data\CalculationData;
use App\Models\Calculation;
use Inertia\Inertia;
use Spatie\LaravelData\PaginatedDataCollection;

class CalculatorController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('calculator', [
            'calculations' => Inertia::lazy(fn () => CalculationData::collect(Calculation::paginate(), PaginatedDataCollection::class)),
        ]);
    }
}
