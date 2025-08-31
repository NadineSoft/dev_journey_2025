<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Birthday as ModelsBirthday;

class BirthdayForm extends Component
{
    public $name;
    public $date;
    public $notes;
    public $showModal = false;
    public $birthdayId = null;

    protected $listeners = ['editBirthday' => 'loadBirthday', 'openBirthdayForm'];
    protected $rules = [
        'name' => 'required|string|max:255',
        'date' => 'required|date',
    ];

    public function resetForm()
    {
        $this->reset(['name', 'date', 'notes', 'birthdayId']);
    }

    public function openBirthdayForm()
    {
        $this->showModal = true;
    }

    public function loadBirthday($id)
    {
        $birthday = ModelsBirthday::findOrFail($id);
        $this->birthdayId = $birthday->id;
        $this->name = $birthday->name;
        $this->date = $birthday->date;
        $this->notes = $birthday->notes;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        ModelsBirthday::updateOrCreate(
            ['id' => $this->birthdayId],
            ['name' => $this->name, 'date' => $this->date, 'notes' => $this->notes]
        );

        $this->dispatch('birthdaySaved',message : 'The birthday has been saved');
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.birthday-form');
    }
}
