<?php

namespace App\Http\Livewire;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Petition;
use App\Models\UserPetition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ListPetitionController extends Component
{

    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showFilters = false;
    public $sortAsc = false;
    public $code_petition;
    public $subject;
    protected $queryString = ['sorts'];

    public $showEditModal = false;
      public $showPetition = false;
    public $detailPetition = '';
    public UserPetition $editing;
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
            'editing.code_petition' => 'required',
            'editing.subject' => 'required',
        ];
    }

    public function edit(UserPetition $userPetition)
    {
        $this->useCachedRows();
        if ($this->editing->isNot($userPetition)) $this->editing = $userPetition;
        $this->showEditModal = true;
    }


    public function create()
    {
        return redirect()->route('petition-make');
    }

    public function save()
    {

        $this->validate();

        $this->editing->save();
        $this->showEditModal = false;

        if ($this->editing->getKey()) $this->editing = $this->makeBlankUserPetition();
        $this->notify('Solicitud Actualizada con éxito!!');
    }

    public function mount()
    {
        $this->editing = $this->makeBlankUserPetition();
    }

    public function makeBlankUserPetition()
    {
        return UserPetition::make(['date' => now()]);
    }

    public function deleteSelected()
    {
        $selectedRows = $this->selectedRowsQuery->pluck('id');
        $count = 0;
        foreach ($selectedRows as $id) {
            $petition = UserPetition::findOrFail($id);


            // Verificar si existe al menos un Curriculum relacionado
            // if ($faculty->curriculas()->exists() || $faculty->users()->exists() || $faculty->departments()->exists()) {
            //     $this->notify('La facultad  ' . $faculty->name . 'esta relacionado  y no se puede eliminar.');
            //     continue;
            // }
            if ($petition->state_petition == 2) {
                $this->deleteImageStorage($petition->petition_imagen_path,$petition->voucher_imagen_path);
                $petition->delete();
                $count++;
            } else {
                $this->notify('Esta solicitud no se ha podido eliminar ' . $petition->code_petition . '.!');
            }
        }

         $this->editing = $this->makeBlankUserPetition();

        $this->selectPage = false;
        $this->selected = [];
        $this->selectAll = [];
        $this->selectPage = false;
        $this->showDeleteModal = false;
        $this->notify('has eliminado  ' . $count . ' solicitud');
    }

    public function deleteImageStorage($pathPetition, $pathVoucher)
    {
        // $petition_imagen_path = str_replace('storage/', '', $pathPetition);
        // $voucher_imagen_path = str_replace('storage/', '', $pathVoucher);
        if (Storage::disk('public')->exists($pathPetition)) {
            Storage::disk('public')->delete($pathPetition);
        }
        if (Storage::disk('public')->exists($pathVoucher)) {
            Storage::disk('public')->delete($pathVoucher);
        }
    }
     public function show($id)
    {
        // dd($petition);
        $this->detailPetition = UserPetition::with('petition')
            ->with('user_petition')
            ->with('user_processor')
            ->findOrFail($id);
        $this->showPetition = true;
    }
    public function getRowsQueryProperty()
    {
        $query = UserPetition::query()
            ->when($this->filters['search'], function ($query) {
                $query->where('code_petition', 'like', '%' . $this->filters['search'] . '%');
            })
            ->with('user_petition')
            ->with('petition')
            ->where('user_petition_id', Auth::user()->id)
            ->latest()
;
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
        return view('livewire.list-petition-controller', [
            'userPetitions' => $this->rows
        ]);
    }
}
