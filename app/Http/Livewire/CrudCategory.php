<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class CrudCategory extends Component
{
    public $isOpen=false;
    public $search,$category;
    protected $rules=[
        'category.name'	=> 'required',
        'category.slug'	=> 'required',
    ];

    public function render()

    {
        $categories =Category::where('name','like','%'.$this->search.'%')->paginate();
        return view('livewire.crud-category',compact('categories'));
    }
    public function create(){
   // dd('crear');
    $this->isOpen=true;
    }
    public function store(){
        $this->validate();
    }
}
