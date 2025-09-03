<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
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

    protected $listeners = ['birthdaySaved' => '$refresh']; // in loc de refresh putea sa fie $refresh (care forteaza re-renderul)

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
        try {
            $birthday = Birthday::findOrFail($id);
            $this->authorize('delete', $birthday);
            Birthday::where('id',$id)->where('user_id',auth()->id())->delete();
            $this->dispatch('toast', type:'success', message:'Deleted');
        } catch (AuthorizationException $e) {
            $this->dispatch('toast', type:'error', message:'Not allowed');
        }
        $this->resetPage();
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
