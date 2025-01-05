<?php

namespace App\Livewire\Forms\Category;

use App\Models\Category;
use Livewire\Form;

class UpdateCategoryForm extends Form
{
    public $name;

    public function update(Category $category)
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', "unique:categories,hame,{$category->id},id"],
        ]);

        $category->update([
            'name' => $this->name,
        ]);

        return $category;
    }
}
