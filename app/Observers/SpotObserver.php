<?php

namespace App\Observers;

use App\Models\Spot;
use Illuminate\Support\Str;

class SpotObserver
{
    public function creating(Spot $spot)
    {
        $spot->slug = Str::slug($spot->name);
    }
}
