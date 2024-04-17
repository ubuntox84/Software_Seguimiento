<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Petition;
use Livewire\Component;

class MakePetitionController extends Component
{
    use WithPerPagePagination;
    public function render()
    {
        return view('livewire.make-petition-controller',[
            'petitions'=>Petition::get()
        ]);
    }
}
