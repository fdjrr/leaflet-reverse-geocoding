<?php

namespace App\Livewire\Forms\Category;

use App\Models\Category;
use Livewire\Form;

class StoreCategoryForm extends Form
{
    public $name;

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ], attributes: [
            'name' => 'Name',
            'icon' => 'Icon',
        ]);

        $category = Category::create([
            'name' => $this->name,
        ]);

        return $category;
    }
}
