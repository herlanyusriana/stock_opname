<?php

namespace App\Models;

use App\Enums\CountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityLogFactory> */
    use HasFactory;

    protected $fillable = [
        'count_id',
        'user_id',
        'action',
        'from_status',
        'to_status',
        'reason',
    ];

    protected $casts = [
        'from_status' => CountStatus::class,
        'to_status' => CountStatus::class,
    ];

    public function count(): BelongsTo
    {
        return $this->belongsTo(Count::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
