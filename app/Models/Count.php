<?php

namespace App\Models;

use App\Enums\CountStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Count extends Model
{
    /** @use HasFactory<\Database\Factories\CountFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'location_id',
        'user_id',
        'status',
        'shift',
        'production_date',
        'notes',
        'checked_by',
        'checked_at',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'reject_reason',
    ];

    protected $casts = [
        'status' => CountStatus::class,
        'production_date' => 'date',
        'checked_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CountItem::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
