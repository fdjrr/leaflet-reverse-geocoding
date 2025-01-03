<?php

namespace App\Livewire\Spot;

use App\Livewire\Forms\Spot\UpdateSpotForm;
use App\Models\Category;
use App\Models\Spot;
use Livewire\Component;

class Edit extends Component
{
    public UpdateSpotForm $form;
    public ?Spot $spot;

    public function mount(Spot $spot)
    {
        $this->spot = $spot;
        $this->form->fill($spot);
    }

    public function save()
    {
        $spot = $this->form->update($this->spot);

        if ($spot) {
            session()->flash('flash', [
                'type'    => 'success',
                'message' => 'Spot updated successfully',
            ]);
        } else {
            session()->flash('flash', [
                'type'    => 'danger',
                'message' => 'Failed to update spot',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.spot.form', [
            'page_meta'  => [
                'title' => 'Edit Spot',
                'form'  => [
                    'action' => 'save',
                ],
            ],
            'categories' => Category::all(),
        ]);
    }
}
