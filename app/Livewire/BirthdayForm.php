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
            'day' => 'required|numeric|between:1,31',
            'month' => 'required|numeric|between:1,12',
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
        $this->authorize('view', $birthday);
        $this->birthdayId = $birthday->id;
        $this->name = $birthday->name;
        $this->day = str_pad($birthday->day, 2, '0', STR_PAD_LEFT); // Format 03
        $this->month = str_pad($birthday->month, 2, '0', STR_PAD_LEFT); // Format 08
        $this->year = $birthday->year;
        $this->notes = $birthday->notes;
        $this->avatar = null;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $day = (int) ltrim($this->day, '0');
        $month = (int) ltrim($this->month, '0');

        $birthday = Birthday::updateOrCreate(
            ['id' => $this->birthdayId, 'user_id' => auth()->id()],
            ['name' => $this->name, 'user_id' => auth()->id(), 'day' => $day, 'month' => $month, 'year' => $this->year > 0 ? $this->year : null, 'notes' => $this->notes]
        );

        if ($this->avatar != null) {
            $birthday->addMedia($this->avatar)->toMediaCollection('profile_image');
        }

        $this->dispatch('toast', type:'success', message:'The birthday has been saved');
        $this->dispatch('birthdaySaved');
        $this->showModal = false;
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.birthday-form');
    }
}
