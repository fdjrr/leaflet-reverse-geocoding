<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CategoryObserver::class)]
class Category extends Model
{
    use SoftDeletes;

    protected $table = "categories";
    protected $guarded = ["id"];

    public function scopeFilter($query, array $filters)
    {
        $search = $filters["search"] ?? false;

        $query->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereLike("name", "%$search%");
            });
        });
    }

    /**
     * Get all of the spots for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spots(): HasMany
    {
        return $this->hasMany(Spot::class, 'category_id', 'id');
    }
}
