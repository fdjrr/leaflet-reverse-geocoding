<?php

namespace App\Livewire\Forms\Spot;

use App\Models\Spot;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreSpotForm extends Form
{
    public $name;

    public $lat;

    public $long;

    public $category_id;

    public $description;

    public function store()
    {
        $this->validate([
            'name'        => ['required', 'string', 'max:255', 'unique:spots,name'],
            'lat'         => ['required', 'string', 'max:255'],
            'long'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
        ], attributes: [
            'name'        => 'Name',
            'lat'         => 'Latitude',
            'long'        => 'Longitude',
            'category_id' => 'Category',
            'description' => 'Description',
        ]);

        $spot = Spot::create([
            'name'        => $this->name,
            'lat'         => $this->lat,
            'long'        => $this->long,
            'category_id' => $this->category_id,
            'description' => $this->description,
        ]);

        return $spot;
    }
}
