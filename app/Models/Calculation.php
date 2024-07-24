<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCalculation
 */
final class Calculation extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<User, Calculation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
