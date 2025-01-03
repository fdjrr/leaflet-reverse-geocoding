<?php

namespace App\Livewire\Forms\Category;

use App\Models\Category;
use Livewire\Form;

class StoreCategoryForm extends Form
{
    public $name;
    public $icon;
    public $public_id;

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'icon' => ['required', 'image', 'max:1024'],
        ], attributes: [
            'name' => 'Name',
            'icon' => 'Icon',
        ]);

        $category = Category::create([
            'name'      => $this->name,
            'icon'      => $this->icon->store('categories'),
            'public_id' => $this->public_id,
        ]);

        return $category;
    }
}
