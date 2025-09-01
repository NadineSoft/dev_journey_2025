<?php

namespace App\Livewire;

use App\Models\Birthday;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class BirthdayForm extends Component
{
    use WithFileUploads;
    public $name;
    public $day;
    public $month;
    public $year;
    public $notes;
    public $showModal = false;
    public $avatar;
    public $birthdayId = null;

    protected $listeners = ['editBirthday' => 'loadBirthday', 'openBirthdayForm'];
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'nullable|integer|digits:4|between:1900,'. now()->year,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Introduce un nume',
            'day.required' => 'Alege o dată',
            'year.digits' => 'Anul trebuie să aibă exact 4 cifre',
            'year.between' => 'Anul trebuie să fie între 1900 și ' . now()->year,
        ];
    }

    public function resetForm()
    {
        $this->reset(['name', 'day','month','year', 'avatar', 'notes', 'birthdayId']);
    }

    public function openBirthdayForm()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function loadBirthday($id)
    {
        $birthday = Birthday::findOrFail($id);
        $this->birthdayId = $birthday->id;
        $this->name = $birthday->name;
        $this->day = $birthday->day;
        $this->month = $birthday->month;
        $this->year = $birthday->year;
        $this->notes = $birthday->notes;
        $this->avatar = null;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $birthday = Birthday::updateOrCreate(
            ['id' => $this->birthdayId, 'user_id' => auth()->id()],
            ['name' => $this->name, 'user_id' => auth()->id(), 'day' => $this->day, 'month' => $this->month, 'year' => $this->year > 0 ? $this->year : null, 'notes' => $this->notes]
        );

        if ($this->avatar != null) {
            $birthday->addMedia($this->avatar)->toMediaCollection('profile_image');
        }

        $this->dispatch('birthdaySaved',message : 'The birthday has been saved');
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.birthday-form');
    }
}
