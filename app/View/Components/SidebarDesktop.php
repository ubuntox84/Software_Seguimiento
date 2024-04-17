<?php

namespace App\View\Components;

use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SidebarDesktop extends Component
{
    public $configuration;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->configuration = Configuration::with('faculty', 'department')
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar-desktop');
    }
}
