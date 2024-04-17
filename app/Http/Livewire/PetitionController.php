<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Petition;
use Livewire\Component;

use Illuminate\Validation\Rule;

class PetitionController extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showFilters = false;
    public $sortAsc = false;
    protected $queryString = ['sorts'];

    public $showEditModal = false;
    public Petition $editing;
    public $filters = [
        'search' => '',
    ];

    protected $listeners = ['refreshPetition' => '$refresh'];
    protected $messages = [

        // 'editing.abbreviation.max' => 'El campo abreviación no debe ser mayor que 8 caracteres.',
        // 'editing.resolution.unique' => 'Este campo resolución ya se encuentra registrado',
        // 'editing.resolution.max' => 'Este campo resolución no debe tener mas de 100 caracteres',
        // 'editing.resolution.min' => 'Este campo resolución debe tener mínimo 4 caracteres',

        // 'editing.date_approved.required' => 'La fecha de aprobación  es obligatorio',
        // 'editing.date_active.required' => 'La fecha activa es obligatorio',
        // 'editing.date_approved.required' => 'La fecha inactiva es obligatorio',
    ];
    protected function rules()
    {
        return [
            'editing.name' => ['min:4', 'max:100', 'required', Rule::unique('faculties', 'name')->ignore($this->editing->id)],
            'editing.code' => 'nullable|max:50',
            'editing.state' => 'nullable|numeric',
            'editing.description' => 'nullable|max:500',



        ];
    }

    public function edit(Petition $petition)
    {
        $this->useCachedRows();
        if ($this->editing->isNot($petition)) $this->editing = $petition;
        $this->showEditModal = true;
    }


    public function create()
    {
        $this->useCachedRows();
        if ($this->editing->getKey()) $this->editing = $this->makeBlankPetition();
        $this->showEditModal = true;
    }

    public function save()
    {

        $this->validate();
        if ($this->editing->id !== null) {
            $this->editing->save();
            $this->showEditModal = false;

            if ($this->editing->getKey()) $this->editing = $this->makeBlankPetition();
            $this->notify('Solicitud Actualizada con éxito!!');
        } 
        else {
            // dd('asdfasdf');
            $this->editing->state=1;
            $this->editing->save();
            // $this->reset();
            $this->showEditModal = false;

            if ($this->editing->getKey()) $this->editing = $this->makeBlankPetition();
            $this->notify('Solicitud Creada con éxito!');
        }
    }
   
    public function mount()
    {
        $this->editing = $this->makeBlankPetition();
    }

    public function makeBlankPetition()
    {
        return Petition::make(['date' => now()]);
    }
   
    public function deleteSelected()
    {
        $selectedRows = $this->selectedRowsQuery->pluck('id');
        $count = 0;
        foreach ($selectedRows as $id) {
            $petition = Petition::findOrFail($id);

            // Verificar si existe al menos un Curriculum relacionado
            // if ($faculty->curriculas()->exists() || $faculty->users()->exists() || $faculty->departments()->exists()) {
            //     $this->notify('La facultad  ' . $faculty->name . 'esta relacionado  y no se puede eliminar.');
            //     continue;
            // }

            $petition->delete();
            $count++;
        }

        $this->selectPage = false;
        $this->selected = [];
        $this->selectAll = [];
        $this->selectPage = false;
        $this->showDeleteModal = false;
        $this->notify('has eliminado  ' . $count . ' solicitud');
    }
   
   
    public function getRowsQueryProperty()
    {
        $query =  Petition::query()
            ->select('id', 'name', 'code','description','state',)
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
                   
            });
        return  $this->applySorting($query);
    }
    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }
    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = !$this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }
    public function render()
    {
        return view('livewire.petition-controller',[
              'petitions' => $this->rows,
        ]);
    }
}
