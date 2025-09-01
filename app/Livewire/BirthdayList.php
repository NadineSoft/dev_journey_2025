<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\Birthday;
use Livewire\WithPagination;

class BirthdayList extends Component
{
    use WithPagination;

    public $search = '';
    public $range = '';
    public $sortColumn = '';
    public $sortDirection = '';

    protected $listeners = ['birthdaySaved' => 'refresh']; // in loc de refresh putea sa fie $refresh (care forteaza re-renderul)

    public function refresh($message)
    {
        //$this->dispatch('refresh'); - nu mai trebuie el deja va face singur refresh
        session()->flash('message', $message);
    }

    public function updating($name, $value)
    {
        if ($name === 'search' || $name === 'range') {
            $this->resetPage();
        }
    }

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function delete($id)
    {
        Birthday::destroy($id);
        session()->flash('message', 'Birthday has been deleted');
        $this->resetPage(); // reseteaza paginarea sa nu ramin cu pagina goala
    }
    public function render()
    {
        $direction = $this->sortDirection ?? 'asc';
            $birthdays = Birthday::query()
                ->where('user_id', auth()->id())
                ->when($this->search, function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })
                ->when($this->range === 'this_week', fn ($q) => $q->thisWeek())
                ->when($this->range === 'upcoming',  fn ($q) => $q->upcoming())
                ->when($this->sortColumn === 'name', fn ($q) => $q->orderBy($this->sortColumn, $direction))
                ->when($this->sortColumn === 'date', fn ($q) => $q->orderBy('month', $direction)->orderBy('day', $direction),)
                ->paginate(10);
        return view('livewire.birthday-list', compact('birthdays'));
    }
}
