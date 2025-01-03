<?php

namespace App\Livewire\Category;

use App\Livewire\Forms\Category\StoreCategoryForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public StoreCategoryForm $form;

    public function save()
    {
        $category = $this->form->store();

        if ($category) {
            $this->form->reset();
            session()->flash('flash', [
                'type'    => 'success',
                'message' => 'Category created successfully',
            ]);
        } else {
            session()->flash('flash', [
                'type'    => 'danger',
                'message' => 'Failed to create category',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.category.form', [
            'page_meta' => [
                'title' => 'Create Category',
                'form'  => [
                    'action' => 'save',
                ],
            ],
        ]);
    }
}
