<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandeImage extends Model
{
    protected $fillable = [
        'commande_id',
        'image_path',
        'original_name',
        'mime_type',
        'size'
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
