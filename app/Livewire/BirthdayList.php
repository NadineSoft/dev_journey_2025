<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\Birthday as ModelsBirthday;
use Livewire\WithPagination;

class BirthdayList extends Component
{
    use WithPagination;

    public $search = '';

    protected $listeners = ['birthdaySaved' => 'refresh']; // in loc de refresh putea sa fie $refresh (care forteaza re-renderul)

    public function refresh($message)
    {
        $this->dispatch('refresh');
        session()->flash('message', $message);
    }

    public function delete($id)
    {
        ModelsBirthday::destroy($id);
        session()->flash('message', 'Birthday has been deleted');
    }
    public function render()
    {
        $birthdays = ModelsBirthday::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);
        return view('livewire.birthday-list', compact('birthdays'));
    }
}
