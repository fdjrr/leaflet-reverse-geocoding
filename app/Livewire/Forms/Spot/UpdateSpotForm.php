<?php

namespace App\Livewire\Forms\Spot;

use App\Models\Spot;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSpotForm extends Form
{
    public $name;

    public $image_path;

    public $lat;

    public $long;

    public $category_id;

    public $description;

    public function update(Spot $spot)
    {
        $this->validate([
            'name'        => ['required', 'string', 'max:255', "unique:spots,name,{$spot->id},id"],
            'image_path'  => ['required', 'image', 'max:1024'],
            'lat'         => ['required', 'string', 'max:255'],
            'long'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
        ], attributes: [
            'name'        => 'Name',
            'image_path'  => 'Image',
            'lat'         => 'Latitude',
            'long'        => 'Longitude',
            'category_id' => 'Category',
            'description' => 'Description',
        ]);

        $spot->update([
            'name'        => $this->name,
            'image_path'  => $spot->image_path === $this->image_path ? $spot->image_path : $this->image_path->store('spots'),
            'lat'         => $this->lat,
            'long'        => $this->long,
            'category_id' => $this->category_id,
            'description' => $this->description,
        ]);

        return $spot;
    }
}
