<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtenir le message actif
     */
    public static function getActiveMessage()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Désactiver tous les autres messages
     */
    public function activate()
    {
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }
}
