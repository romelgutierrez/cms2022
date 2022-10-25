<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class CrudCategory extends Component
{
    public $isOpen=false;
    public $search,$category;
    protected $listeners=['render','delete'=>'delete'];

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
    $this->reset('category');
    }
    public function store(){
        $this->validate();
        if(!isset($this->category['id'])){
            Category::create($this->category);
        }else{
            $category=Category::find($this->category['id']);
            $category->name=$this->category['name'];
            $category->slug=$this->category['slug'];
            $category->save();
        }
        $this->reset(['isOpen','category']);
        $this->emitTo('CrudCategory','render');
        $this->emit('alert','Registro creado satisfactoriamente');

    }

    public function edit($category){
        $this -> category =$category;
        $this->isOpen=true;;
    }
    public function updatedCategoryName(){
        //dd('hola');
        $this->category['slug']=Str::slug ($this->category['name']);

    }
    public function delete($id){
        Category::find($id)->delete();
    }

}
