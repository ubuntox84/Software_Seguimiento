<?php

namespace App\Http\Livewire;

use App\Exports\UsersExport;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserController extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showDeleteModal = false;
    public $showFilters = false;
    public $sortAsc = false;
    public $faculties;
    public $departments;
    public $detailUser;
    public $showModalDetailUser = false;
    public $roles;
    public $selectedRoles = [];
    public $state = [
        'faculty_id' => ''
    ];
    protected $queryString = ['sorts'];

    public $showEditModal = false;
    public User $editing;
    public $filters = [
        'search' => '',
        'date-min' => null,
        'date-max' => null,
    ];

    protected $listeners = ['refreshFaculties' => '$refresh'];
    protected $messages = [

        'editing.faculty_id.required' => 'El  campo Facultad es obligatorio',
        'editing.code.required' => 'El  campo Código es obligatorio',
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
            'editing.name' => 'required|max:255',
            'editing.surname' => 'required|max:255',
            'editing.code' => 'required|max:10',
            'editing.email' => 'required|email',
            'editing.faculty_id' => 'required|numeric|exists:faculties,id',
            'editing.department_id' => 'nullable|numeric|exists:departments,id',
            // 'editing.abbreviation' => 'nullable|max:8',
        ];
    }
     public function showDetailUser($id)
    {
        $this->detailUser = User::with('faculties', 'departments','roles')->where('id', $id)->first();
        $this->showModalDetailUser = true;
    }
    public function edit(User $user)
    {
        $this->useCachedRows();
        if ($this->editing->isNot($user)) $this->editing = $user;
        $this->selectedRoles = $this->editing->roles()->pluck('id')->toArray();
        $this->faculties = Faculty::all();
        $this->departments = Department::select('id', 'name')->where('faculty_id', $this->editing->faculty_id)->get();
        $this->showEditModal = true;
    }
    public function addRole($id)
    {

        if (in_array($id, $this->selectedRoles)) {
            unset($this->selectedRoles[array_search($id, $this->selectedRoles)]);
        } else {
            $this->selectedRoles = [...$this->selectedRoles, $id];
        }
    }
    public function exportSelected()
    {

        if (!empty($this->selected)) {
            // dd($this->selected->toArray());
            if (is_object($this->selected)) {
                return (new UsersExport($this->selected->toArray()))->download('users.xlsx');
            } else {
                return (new UsersExport($this->selected))->download('users.xlsx');
            }
        } else {
            return  $this->notify('Seleccione una Fila');
        }
    }
    public function create()
    {
        $this->useCachedRows();
        if ($this->editing->getKey()) $this->editing = $this->makeBlankUser();
        $this->showEditModal = true;
    }
    public function save()
    {

        $this->validate();
         $department_id = null;
        if (isset( $this->editing->department_id) &&  $this->editing->department_id !== '') {
            $department_id = (int)  $this->editing->department_id;
        }
        if ($this->editing->id !== null) {
            $this->editing->department_id=$department_id;
            $this->editing->save();
            $this->editing->syncRoles($this->selectedRoles);

            $this->showEditModal = false;

            if ($this->editing->getKey()) $this->editing = $this->makeBlankUser();
            $this->notify('Usuario Actualizado con éxito!!');
        } else {
            // dd('asdfasdf');  
            $this->editing->department_id=$department_id;
            $this->editing->save();
            $this->editing->syncRoles($this->selectedRoles);
            // $this->reset();
            $this->showEditModal = false;

            if ($this->editing->getKey()) $this->editing = $this->makeBlankUser();
            $this->notify('Usuario Creado con éxito!');
        }
    }
    public function mount()
    {
        $this->faculties=[];
        $this->roles = Role::all();
        $this->editing = $this->makeBlankUser();
        $this->departments = [];
    }
    public function selectDepartments()
    {
        // dd($this->editing->faculty_id);
        $this->departments = Department::where('faculty_id', intval($this->editing->faculty_id))->get();
        if (count($this->departments) == 0) {
            $this->state['department_id'] = '';
        }
    }
    public function cancelFormPre()
    {

        $this->showModalDetailUser= false;


        $this->resetValidation();
    }
    public function makeBlankUser()
    {
        return User::make(['date' => now()]);
    }
    public function deleteSelected()
    {
        $selectedRows = $this->selectedRowsQuery->pluck('id');
        $count = 0;
        foreach ($selectedRows as $id) {
            $user = User::findOrFail($id);

            // Verificar si existe al menos un Curriculum relacionado
            // if ($user->curriculas()->exists()) {
            //    $this->notify('La facultad  ' . $user->name . ' tiene currículos relacionados y no se puede eliminar.');
            //     continue;
            // }

            $user->delete();
            $count++;
        }
        $this->selectPage = false;
        $this->selected = [];
        $this->selectAll = [];
        $this->selectPage = false;
        $this->showDeleteModal = false;
        $this->notify('has eliminado  ' . $count . ' usuarios');
    }

    public function getRowsQueryProperty()
    {
        $user = Auth::user();
        // dd($user->role);
        if ($user->hasRole('admin')) {
            $query =  User::query()
                ->when($this->filters['date-min'], fn ($query, $date_min) => $query->where('created_at', '>=', Carbon::parse($date_min)))
                ->when($this->filters['date-max'], fn ($query, $date_max) => $query->where('created_at', '<=', Carbon::parse($date_max)))
                ->when($this->filters['search'], function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('surname', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                         ->orWhereHas('faculties', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        })
                         ->orWhereHas('departments', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        })
                         ->orWhereHas('roles', function ($query) {
                            $query->where('name', 'like', '%' . $this->filters['search'] . '%');
                        });
                })
                ->with('roles','faculties','departments');
            return  $this->applySorting($query);
        } 
        // else {
        //     $query =  User::query()
        //         ->when($this->filters['date-min'], fn ($query, $date_min) => $query->where('created_at', '>=', Carbon::parse($date_min)))
        //         ->when($this->filters['date-max'], fn ($query, $date_max) => $query->where('created_at', '<=', Carbon::parse($date_max)))
        //         ->when($this->filters['search'], function ($query, $search) {
        //             $query->where('name', 'like', '%' . $search . '%')
        //                 ->orWhere('surname', 'like', '%' . $search . '%')
        //                 ->orWhere('code', 'like', '%' . $search . '%')
        //                 ->orWhere('email', 'like', '%' . $search . '%');
        //         })
        //         ->where('faculty_id', Auth::user()->faculty_id)
        //         ->with('roles');
        //     return  $this->applySorting($query);
        // }
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
        return view('livewire.user-controller', [
            'users' => $this->rows,
        ]);
    }
}
