<?php

namespace App\Http\Livewire;

use App\Exports\FacultiesExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Department;
use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FacultyController extends Component
{
     use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;
     
    public $showDeleteModal = false;
    public $showDeleteModalDepartment = false;
    public $showFilters = false;
    public $sortAsc = false;
     protected $queryString = ['sorts'];

    public $showEditModal = false;
    public $showEditModalDepartment = false;
    public $faculty_id;
    public $department_id;
     public Faculty $editing;
     public Department $editingDepartment;
     public $filters = [
        'search' => '',
        'date-min' => null,
        'date-max' => null,
    ];

    protected $listeners = ['refreshFaculties' => '$refresh'];
 protected $messages = [

        'editing.abbreviation.max' => 'El campo abreviación no debe ser mayor que 8 caracteres.',
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
            'editing.name' => ['min:4', 'max:200', 'required', Rule::unique('faculties', 'name')->ignore($this->editing->id)],
            'editing.abbreviation' => 'nullable|max:8',

             'editingDepartment.name' => ['min:4', 'max:200', 'required', Rule::unique('departments', 'name')->ignore($this->editingDepartment->id)],
           
        ];
    }
   
      public function edit(Faculty $faculty)
    {
        $this->useCachedRows();
        if ($this->editing->isNot($faculty)) $this->editing = $faculty;
        $this->showEditModal = true;
    }
     public function editDepartment(Department $department)
    {
        $this->useCachedRows();
        if ($this->editingDepartment->isNot($department)) $this->editingDepartment = $department;
        $this->showEditModalDepartment = true;
    }
    public function exportSelected()
    {
      
        if(!empty($this->selected))
        {
           // dd($this->selected->toArray());
            if (is_object($this->selected)) {
                return (new FacultiesExport($this->selected->toArray()))->download('facultades.xlsx');
            } else {
                return (new FacultiesExport($this->selected))->download('facultades.xlsx');
            } 
            
        }
        else{
            return  $this->notify('Seleccione una Fila');
        }
        
    }
    public function create()
    {
        $this->useCachedRows();
        if ($this->editing->getKey()) $this->editing = $this->makeBlankFaculty();
        $this->showEditModal = true;
    }
     public function createDepartment($id)
    {
        $this->faculty_id=$id;
        if ($this->editingDepartment->getKey()) $this->editingDepartment = $this->makeBlankDepartment();
        $this->showEditModalDepartment = true;
    }
      public function save()
    {

      $validatedData = $this->validate(
            [
                  'editing.name' => ['min:4', 'max:200', 'required', Rule::unique('faculties', 'name')->ignore($this->editing->id)],
            'editing.abbreviation' => 'nullable|max:8',
              

            ]);
        if ($this->editing->id !== null) {
            $this->editing->save();
            $this->showEditModal = false;
            
        if ($this->editing->getKey()) $this->editing = $this->makeBlankFaculty();
            $this->notify('Facultad Actualizada con éxito!!');
        } else {
            // dd('asdfasdf');
            $this->editing->save();
            // $this->reset();
            $this->showEditModal = false;

        if ($this->editing->getKey()) $this->editing = $this->makeBlankFaculty();
            $this->notify('Facultad Creada con éxito!');
        }
    }
       public function saveDepartment()
    {

        $validatedData = $this->validate(
            [
                'editingDepartment.name' => [
                    'required',
                    Rule::unique('departments', 'name')->ignore($this->editingDepartment->id),
                    'min:4',
                    'max:200'
                ],
              

            ]);

        if ($this->editingDepartment->id !== null) {
            $this->editingDepartment->save();
            $this->showEditModalDepartment = false;
            
        if ($this->editingDepartment->getKey()) $this->editingDepartment = $this->makeBlankDepartment();
            $this->notify('Departamento Actualizado con éxito!!');
        } else {
            // dd('asdfasdf');
            $this->editingDepartment->faculty_id=$this->faculty_id;
            $this->editingDepartment->save();
            // $this->reset();
            $this->showEditModalDepartment = false;

        if ($this->editingDepartment->getKey()) $this->editingDepartment = $this->makeBlankDepartment();
            $this->notify('Departamento Creada con éxito!');
        }
        $this->faculty_id='';
    }
    public function mount()
    {
        $this->editing = $this->makeBlankFaculty();
        $this->editingDepartment = $this->makeBlankDepartment();
    }

    public function makeBlankFaculty()
    {
        return Faculty::make(['date' => now()]);
    }
 public function makeBlankDepartment()
    {
        return Department::make(['date' => now()]);
    }
  public function deleteSelected()
    {
        $selectedRows = $this->selectedRowsQuery->pluck('id');
        $count = 0;
        foreach ($selectedRows as $id) {
        $faculty = Faculty::findOrFail($id);

        // Verificar si existe al menos un Curriculum relacionado
        if ($faculty->curriculas()->exists() || $faculty->users()->exists() || $faculty->departments()->exists() ) {
           $this->notify('La facultad  ' . $faculty->name . 'esta relacionado  y no se puede eliminar.');
            continue;
        }

        $faculty->delete();
        $count++;

    }

        $this->selectPage=false;
        $this->selected=[];
        $this->selectAll=[]; 
        $this->selectPage = false;
        $this->showDeleteModal = false;
        $this->notify('has eliminado  ' . $count . ' facultad');
    }
 public function ShowModalDelete($id)
    {
       $this->department_id=$id;
       $this->showDeleteModalDepartment=true;
    }
    public function deleteDepartment()
    {
       
        $department = Department::findOrFail($this->department_id);

        // Verificar si existe al menos un Curriculum relacionado
        if ($department->users()->exists()) {
           $this->notify('El departamento  ' . $department->name . ' esta relacionado  y no se puede eliminar.');
            return;
        }

        $department->delete();
    
        $this->showDeleteModalDepartment = false;
        $this->department_id='';
        $this->notify('El registro ha sido eliminado con éxito');
    }
 public function getRowsQueryProperty()
    {
        $query =  Faculty::query()->with('departments')
            ->select('id','name','abbreviation')
            ->when($this->filters['date-min'], fn ($query, $date_min) => $query->where('created_at', '>=', Carbon::parse($date_min)))
            ->when($this->filters['date-max'], fn ($query, $date_max) => $query->where('created_at', '<=', Carbon::parse($date_max)))
            ->when($this->filters['search'], function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('abbreviation', 'like', '%' . $search . '%')
                      ->orWhereHas('departments', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        });
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
        return view('livewire.faculty-controller',[
             'faculties' => $this->rows,
        ]);
    }
}
