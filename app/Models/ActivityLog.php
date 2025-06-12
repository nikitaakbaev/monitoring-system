<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
    ];

    /**
     * Create a log entry if the table exists.
     */
    public static function safeCreate(array $attributes): void
    {
        try {
            if (Schema::hasTable((new self())->getTable())) {
                self::create($attributes);
            }
        } catch (\Throwable $e) {
            // Table might not exist yet; ignore logging failures
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
