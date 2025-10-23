<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Birthday extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'day',
        'month',
        'year',
        'notes',
        'user_id',
    ];

    // Birthday → User e o relație BelongsTo (un Birthday aparține unui User).
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getDisplayDateAttribute(): string
    {
        $d = str_pad($this->day, 2, '0', STR_PAD_LEFT);
        $m = str_pad($this->month, 2, '0', STR_PAD_LEFT);
        if ($this->year) {
            return \Carbon\Carbon::create($this->year, $this->month, $this->day)->format('F, j Y');
        }
        return \Carbon\Carbon::create(2000, $this->month, $this->day)->format('F, j');
    }


// Scope pentru "This Week"
    public function scopeThisWeek($query)
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Luni
        $endOfWeek = Carbon::now()->endOfWeek(); // Duminică

        return $query->where(function ($q) use ($startOfWeek, $endOfWeek) {
            $q->where('month', '>=', $startOfWeek->month)
                ->where('month', '<=', $endOfWeek->month)
                ->where('day', '>=', $startOfWeek->day)
                ->where('day', '<=', $endOfWeek->day);
        });
    }

    public function scopeUpcoming($query)
    {
        $today = Carbon::today();
        $oneMonthFromNow = $today->copy()->addMonth();

        return $query->where(function ($q) use ($today, $oneMonthFromNow) {
            $q->where('month', '>=', $today->month)
                ->where('month', '<=', $oneMonthFromNow->month)
                ->where('day', '>=', $today->day);
        });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_image')->singleFile();
    }
}
