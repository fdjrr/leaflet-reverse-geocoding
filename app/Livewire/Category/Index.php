<?php

namespace App\Livewire\Category;

use App\Models\Category;
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
        $categories = Category::query()->filter([
            'search' => $this->search,
        ])->paginate(10)->withQueryString();

        return view('livewire.category.index', [
            'page_meta'  => [
                'title' => 'Category',
            ],
            'categories' => $categories,
        ]);
    }
}
