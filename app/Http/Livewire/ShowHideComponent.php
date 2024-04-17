<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowHideComponent extends Component
{
    public $showModuleCurricula = true;
    public $showModuleCourse = false;
    public $counter = 0;
    public $ShowDropdownMenu = false;

    public function render()
    {
        return view('livewire.show-hide-component');
    }
    public function ShowDropdownMenu()
    {
        $this->ShowDropdownMenu = !$this->ShowDropdownMenu;
    }

    public function showModuleCurricula()
    {
        $this->showModuleCourse = false;
        $this->showModuleCurricula = true;
    }
    public function showModuleCourse()
    {
        $this->showModuleCurricula = false;
        $this->showModuleCourse = true;
    }
}
