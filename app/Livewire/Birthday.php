<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Birthday as ModelsBirthday;

class Birthday extends Component
{
    public $name;
    public $date;
    public $notes;
    public $birthdays;

    public $editId = null;
    public $modalTitle = null;
    public $addBdModal = false;
    public function mount()
    {
        $this->getBirhdays();
    }

    public function getBirhdays()
    {
        $this->birthdays = ModelsBirthday::all();
    }

    public function showModal($id=null)
    {
        $this->addBdModal = true;
        if ($id != null) {
            $this->editId = $id;
            $bd = ModelsBirthday::find($this->editId);
            $this->name = $bd->name;
            $this->date = $bd->date;
            $this->notes = $bd->notes;
        }

    }

    public function store()
    {
        if (empty($this->name) || empty($this->date)) {
            session()->flash('error', 'Fields must not be empty');
            return false;
        }
        $data = [
            'name' => $this->name,
            'date' => $this->date,
            'notes' => $this->notes,
        ];
        if ($this->editId) {
            ModelsBirthday::find($this->editId)->update($data);
        } else {
            ModelsBirthday::create($data);
        }
        $this->addBdModal = false;
        $this->editId = null;
        $this->getBirhdays();
    }

    public function delete($id)
    {
        ModelsBirthday::destroy($id);
        $this->getBirhdays();
    }
    public function render()
    {
        return view('livewire.birthday');
    }
}
