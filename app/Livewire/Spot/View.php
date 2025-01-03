<?php

namespace App\Livewire\Spot;

use Livewire\Component;

class View extends Component
{
    public function render()
    {
        return view('livewire.spot.view', [
            'page_meta' => [
                'title' => 'View Spot',
            ],
        ]);
    }
}
