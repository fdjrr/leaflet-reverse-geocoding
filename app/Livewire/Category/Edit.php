<?php

namespace App\Livewire\Category;

use App\Livewire\Forms\Category\UpdateCategoryForm;
use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public ?Category $category;
    public UpdateCategoryForm $form;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->form->fill($category);
    }

    public function save()
    {
        $category = $this->form->update($this->category);

        if ($category) {
            session()->flash('flash', [
                'type'    => 'success',
                'message' => 'Category updated successfully',
            ]);
        } else {
            session()->flash('flash', [
                'type'    => 'danger',
                'message' => 'Failed to update category',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.category.form', [
            'page_meta' => [
                'title' => 'Edit Category',
                'form'  => [
                    'action' => 'save',
                ],
            ],
        ]);
    }
}
