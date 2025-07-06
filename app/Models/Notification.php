<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'user_id',
        'action',
        'changes',
        'description'
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
