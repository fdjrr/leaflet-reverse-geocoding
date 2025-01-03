<?php

namespace App\Livewire\Spot;

use App\Models\Spot;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search;

    public function render()
    {
        $spots = Spot::query()->with(['category'])->filter([
            'search' => $this->search,
        ])->paginate(10)->withQueryString();

        return view('livewire.spot.index', [
            'page_meta' => [
                'title' => 'Spot',
            ],
            'spots'     => $spots,
        ]);
    }
}
