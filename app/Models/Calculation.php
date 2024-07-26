<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCalculation
 */
final class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'expression',
        'result',
    ];
}
