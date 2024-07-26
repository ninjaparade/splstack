<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use Illuminate\Support\Facades\Redirect;

class CalculateDeleteController extends Controller
{
    public function __invoke(Calculation $calculation)
    {
        $calculation->delete();

        return Redirect::route('calculator');
    }
}
