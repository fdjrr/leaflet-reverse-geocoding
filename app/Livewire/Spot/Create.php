<?php

namespace App\Livewire\Spot;

use App\Livewire\Forms\Spot\StoreSpotForm;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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
        } else {
            session()->flash('flash', [
                'type'    => 'danger',
                'message' => 'Failed to create spot',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.spot.form', [
            'page_meta'  => [
                'title' => 'Create Spot',
                'form'  => [
                    'action' => 'save',
                ],
            ],
            'categories' => Category::all(),
        ]);
    }
}
