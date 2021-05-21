<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportProcess extends Model
{
    use HasFactory;

    /**
     * Fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'filepath',
    ];

    /**
     * Cast to native data types
     *
     * @var array
     */
    protected $casts = [
        'processed' => 'boolean'
    ];

    /**
     * Return the User related model
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
