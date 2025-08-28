<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Birthday as ModelsBirthday;

class Birthday extends Component
{
    public $birthdays;

    public function mount()
    {
        $this->birthdays = ModelsBirthday::all();
    }
    public function render()
    {
        return view('livewire.birthday');
    }
}
