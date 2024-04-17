<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
      
    }
    public function render()
    {
        return view('livewire.home');
    }
}
