<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:3|max:50')]
    public $name;

    public $search;

    public $editingtodoID;
    public $editingTodoName;

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

    public  function delete($todoID){
        Todo::find($todoID)->delete();
    }

    public function toogle($todoID){
        $todo = Todo::find($todoID);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function edit($todoID){
        $this->editingtodoID = $todoID;
        $this->editingTodoName = Todo::find($todoID)->name;
    }

    public function render()
    {
        return view('livewire.todo-list',[
            'todos'=>Todo::latest()->where('name','like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
