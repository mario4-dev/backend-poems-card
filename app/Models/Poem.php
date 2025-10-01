<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'author',
        'color',
        'user_id',
        'published',
    ];

    /**
     * Get the user that owns the poem.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
