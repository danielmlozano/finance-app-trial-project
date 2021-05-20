<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    use HasFactory;

    /**
     * Fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'amount',
        'date',
    ];

    /**
     * Convert to propper data types
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];


    /**
     * Return the user related model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
