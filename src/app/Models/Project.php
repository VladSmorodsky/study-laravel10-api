<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, Member::class);
    }

    public static function booted()
    {
        static::addGlobalScope('creator', function (Builder $builder) {
            $builder->where('creator_id', Auth::id());
        });
    }
}
