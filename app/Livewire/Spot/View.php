<?php

namespace App\Livewire\Spot;

use App\Livewire\Forms\Spot\StoreSpotForm;
use App\Models\Category;
use Livewire\Component;

class View extends Component
{
    public StoreSpotForm $form;

    public function save()
    {
        $spot = $this->form->store();

        if ($spot) {
            $this->form->reset();

            session()->flash('flash', [
                'type'    => 'success',
                'message' => 'Spot created successfully',
            ]);

            $this->dispatch('closeCreateSpotModal');
        } else {
            session()->flash('flash', [
                'type'    => 'danger',
                'message' => 'Failed to create spot',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.spot.view', [
            'page_meta'  => [
                'title' => 'View Spot',
                'form'  => [
                    'action' => 'save',
                ],
            ],
            'categories' => Category::all(),
        ]);
    }
}
