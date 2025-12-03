<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountItem extends Model
{
    /** @use HasFactory<\Database\Factories\CountItemFactory> */
    use HasFactory;

    protected $fillable = [
        'count_id',
        'part_id',
        'quantity',
        'production_date',
        'shift',
    ];

    protected $casts = [
        'production_date' => 'date',
    ];

    public function count(): BelongsTo
    {
        return $this->belongsTo(Count::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }
}
