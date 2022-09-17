<?php

namespace App\Models;

use App\Events\ChirpCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chirp extends Model
{
    use HasFactory;

    protected $fillable = [
        "message"
    ];

    protected $dispatchesEvents = [
        'created' => ChirpCreated::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function like(User $user) {
        $this->likes()->create([
            'user_id' => $user->id
        ]);
    }
    
    public function unlike(User $user) {
        $this->likedBy($user)->delete();
    }

    public function likedBy(User $user) {
        return $this->likes()->firstWhere('user_id', $user->id);
    }
}
