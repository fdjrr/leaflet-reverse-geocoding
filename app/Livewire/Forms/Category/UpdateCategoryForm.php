<?php

namespace App\Livewire\Forms\Category;

use App\Models\Category;
use Livewire\Form;

class UpdateCategoryForm extends Form
{
    public $name;
    public $icon;
    public $public_id;

    public function update(Category $category)
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', "unique:categories,hame,{$category->id},id"],
        ]);

        $category->update([
            'name'      => $this->name,
            'icon'      => $category->icon === $this->icon ? $category->icon : $this->icon->store('categories'),
            'public_id' => $this->public_id,
        ]);

        return $category;
    }
}
