<?php

namespace App\Models;

use App\Observers\SpotObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SpotObserver::class)]
class Spot extends Model
{
    use SoftDeletes;

    protected $table = "spots";
    protected $guarded = ['id'];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters['search'] ?? false;
    }

    /**
     * Get the category that owns the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
