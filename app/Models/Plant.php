<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant extends Model
{
    // Fields that can be assigned through mass assignment.
    protected $fillable = [
        'user_id',
        'plant_name',
        'category',
        'unit_price',
        'description',
        'stock_status',
    ];

    // Define the relationship between Plant and User.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
