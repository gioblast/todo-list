<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TodoList extends Component
{
    #[Rule('required|min:3|max:50')]
    public $name;

    public $search;

    public function create(){
        //validate
        //create the todo
        //clear the input
        // send flash message
        $validated = $this->validateOnly('name');

        Todo::create($validated);
        $this->reset('name'); //para que se elimine una ves ingresado

        session()->flash('success','creado.');
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
