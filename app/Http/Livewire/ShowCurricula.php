<?php

namespace App\Http\Livewire;

use App\Exports\CurriculasExport;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Curricula;
use Carbon\Carbon;

use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class ShowCurricula extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;


    public $showDeleteModal = false;
    public $showFilters = false;
    public $sortAsc = false;
    public $showModalDetailCurricula =false;
    public $detailCurricula;
    public $apiShow = false;
    public $filters = [
        'search' => '',
        'state' => true,
        'date-min' => null,
        'date-max' => null,
    ];
    public $listCurriculas;
    public Curricula $editing;
    protected $queryString = ['sorts'];


    public $url = 'https://pdfapi-a7a4.onrender.com/curricula/list';
    public $urlCourses = 'https://pdfapi-a7a4.onrender.com/curricula?ep=';

    public $showEditModal = false;
    protected function rules()
    {
        return [
            'editing.name' => ['min:4', 'max:200', 'required', Rule::unique('curriculas', 'name')->ignore($this->editing->id)],
            'editing.resolution' => ['min:4', 'max:100', 'required', Rule::unique('curriculas', 'resolution')->ignore($this->editing->id)],
            'editing.date_approved' => 'required',
            'editing.date_active' => 'required',
            'editing.date_inactive' => 'required',

            'editing.code' => 'required',
            'editing.profesional_school' => 'required',
            'editing.semester_start' => 'required',
            'editing.compulsory' => 'required',
            'editing.elective' => 'required|numeric',
            'editing.free_activity' => 'required|numeric',
            'editing.pre_professional_practice' => 'required|numeric',
        ];
    }
    protected $messages = [

        'editing.resolution.required' => 'El  campo resolución es obligatorio',
        'editing.resolution.unique' => 'Este campo resolución ya se encuentra registrado',
        'editing.resolution.max' => 'Este campo resolución no debe tener mas de 100 caracteres',
        'editing.resolution.min' => 'Este campo resolución debe tener mínimo 4 caracteres',

        'editing.date_approved.required' => 'La fecha de aprobación  es obligatorio',
        'editing.date_active.required' => 'La fecha activa es obligatorio',
        'editing.date_approved.required' => 'La fecha inactiva es obligatorio',

        'editing.code.required' => 'El campo código  es obligatorio',
        'editing.profesional_school.required' => 'El campo escuela profesional es obligatorio',
        'editing.semester_start.required' => 'El campo inicio de semestre es obligatorio',
        'editing.compulsory.required' => 'El campo es obligatorio',
        'editing.elective.required' => 'El campo electivo  es obligatorio',
        'editing.free_activity.required' => 'El campo  actividad libre  es obligatorio',
        'editing.pre_professional_practice.required' => 'El campo pre práctica profesional es obligatorio',

        'editing.compulsory.numeric' => 'El campo obligatorio debe ser numérico',
        'editing.elective.numeric' => 'El campo electivo debe ser  numérico',
        'editing.free_activity.numeric' => 'El campo actividad libre debe ser  numérico',
        'editing.pre_professional_practice.numeric' => 'El campo pre prácticas profesionales debe ser  numérico',
    ];

    protected $listeners = ['refreshCurriculas' => '$refresh'];

    public function updatedShowEditModal()
    {
        $this->resetValidation();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }



    public function edit(Curricula $curricula)
    {
        $this->apiShow = false;
        $this->useCachedRows();
        if ($this->editing->isNot($curricula)) $this->editing = $curricula;
        $this->showEditModal = true;
    }


    public function create()
    {
        $this->useCachedRows();
        if ($this->editing->getKey()) $this->editing = $this->makeBlankCurricula();
        $this->showEditModal = true;
    }
    public function deleteSelected()
    {
        $selectedRows = $this->selectedRowsQuery->pluck('id');
        $count = 0;
        foreach ($selectedRows as $id) {
            $curriulas = Curricula::findOrFail($id);
            // dd($curriulas);

            // Verificar si existe al menos un Curriculum relacionado
            // dd($curriulas->faculties()->exists()       );
            if ($curriulas->areasKnowledge()->exists()) {
                $this->notify('La Currícula  ' . $curriulas->name . ' tiene currículos relacionados y no se puede eliminar.');
                continue;
            } else {
                try {
                    $curriulas->delete();
                    $count++;
                } catch (\Illuminate\Database\QueryException $e) {
                    $this->notify('No se pudo eliminar la currícula debido a una restricción de clave foránea.');
                }
                // $curriulas->delete();
                // $count++;
            }
        }
        // $deleteCount = $this->selectedRowsQuery->count();
        // $this->selectedRowsQuery->delete();
        $this->selected = [];
        $this->selectAll = [];
        $this->selectPage = false;
        $this->showDeleteModal = false;
        $this->notify('has eliminado  ' . $count . ' curriculas');
    }

    public function exportSelected()
    {

        if (!empty($this->selected)) {
            // dd($this->selected->toArray());
            if (is_object($this->selected)) {
                return (new CurriculasExport($this->selected->toArray()))->download('curriculas.xlsx');
            } else {
                return (new CurriculasExport($this->selected))->download('curriculas.xlsx');
            }
        } else {
            return  $this->notify('Seleccione una Fila');
        }
    }
    public function makeBlankCurricula()
    {
        return Curricula::make(['date' => now()]);
    }

    public function mount()
    {
        $this->editing = $this->makeBlankCurricula();
    }

    public function getRowsQueryProperty()
    {


        $query =  Curricula::query()
            ->when($this->filters['date-min'], fn ($query, $date_min) => $query->where('date_approved', '>=', Carbon::parse($date_min)))
            ->when($this->filters['date-max'], fn ($query, $date_max) => $query->where('date_approved', '<=', Carbon::parse($date_max)))
            ->when($this->filters['search'], function ($query, $search) {
                // dd( Auth::user()->faculty_id);
                $query->where('name', 'like', '%' . $search . '%')
                    ->where('state', $this->filters['state'])
                    ->where('department_id', Auth::user()->department_id)
                    ->where('faculty_id', Auth::user()->faculty_id)
                    ->orWhere('resolution', 'like', '%' . $search . '%');
            })
            ->where('state', $this->filters['state'])
            ->where('department_id', Auth::user()->department_id)
            ->where('faculty_id', Auth::user()->faculty_id);

        return  $this->applySorting($query);
    }
    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }
    public function showDetailCurricula($id)
    {
        $this->detailCurricula = Curricula::with('faculties', 'departments')->where('id', $id)->first();
        $this->showModalDetailCurricula = true;
    }
     public function cancelFormPre()
    {

        $this->showModalDetailCurricula= false;


        $this->resetValidation();
    }
    public function save()
    {

        $this->validate();
        if ($this->editing->id !== null) {
            // $this->editing->faculty_id=Auth::user()->faculty_id;
            $this->editing->save();
            $this->showEditModal = false;
            $this->notify('Currícula Actualizada con éxito!!');
        } else {
            Curricula::where('state', '=', true)->where('faculty_id', Auth::user()->faculty_id)->where('department_id', Auth::user()->department_id)
                ->update([
                    'state' => false,
                ]);
            $this->editing->faculty_id = Auth::user()->faculty_id;
            $this->editing->department_id = Auth::user()->department_id;
            $this->editing->save();
            // $this->reset();
            $this->showEditModal = false;
            $this->notify('Currícula Creada con éxito!');
        }
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = !$this->showFilters;
    }
    public function toggleShowApi()
    {
        $this->apiShow = !$this->apiShow;
        $this->listCurriculaApi();
    }

    public function listCurriculaApi()
    {
        try {
            $this->listCurriculas = $this->getDataFromApi();
        } catch (\Exception $e) {
            // Manejo de la excepción en caso de error en la solicitud
            \Log::error('Error en la solicitud a la API: ' . $e->getMessage());
            $this->data = []; // Asigna un arreglo vacío en caso de error
        }
    }
    public function saveCurriculaApi($curriculaJson)
    {



        $existeCodigo = Curricula::where('code', $curriculaJson['codigo'])->exists();

        if ($existeCodigo) {
            return  $this->notify('La curricula ya ha sido registrada anteriormente');
        } else {
            $curricula = $curriculaJson;

            $transformCurricula = [
                'name' => $curricula['plan'],
                'resolution' => empty($curricula['']) ? null : $curricula[''],
                'date_approved' => empty($curricula['']) ? null : $curricula[''],
                'date_active' => empty($curricula['']) ? null : $curricula[''],
                'date_inactive' => empty($curricula['']) ? null : $curricula[''],
                'code' => $curricula['codigo'],
                'profesional_school' => $curricula['escuelaP'],
                'semester_start' => empty($curricula['']) ? null : $curricula[''],
                'compulsory' => $curricula['cObligatorio'],
                'elective' => $curricula['cElectivo'],
                'free_activity' => $curricula['aLibres'],
                'pre_professional_practice' => $curricula['ppp'],
                'state' => $curricula['status'] == 'VIGENTE' ? 1 : 0,
                'faculty_id' => Auth::user()->faculty_id,
                'department_id' => empty(Auth::user()->department_id) ? null : Auth::user()->department_id,
            ];
            $curriculaAPI = Curricula::create($transformCurricula);
            $this->notify('Curricula registrada exitosamente');
            $courses = $this->getDataFromApiCourses($curricula['requestCode']);
            // dd($courses['data']);
            $count = 0;
            if (!isset($courses['data'])) {
                return  $this->notify('No hay cursos para registrar');
            } else {

                foreach ($courses['data'] as $key => $value) {

                    if (is_array($value)) {
                        $course = new Course();
                        $course->code = $value['codigo'];
                        $course->name = $value['nombre'];
                        $course->credits = $value['creditos'];
                        // $course->cycle	 = isset($value['semestre']) ? $value['semestre'] : null;

                        $course->theoretic_hour = isset($value['theoretic_hour']) ? $value['theoretic_hour'] : null;
                        $course->practical_hour = isset($value['practical_hour']) ? $value['practical_hour'] : null;
                        $course->prerequisite = isset($value['prerequisite']) ? $value['prerequisite'] : null;
                        if (isset($value['electivo'])) {
                            $course->type_course = 'electivo';
                        } else {
                            $course->type_course = 'obligatorio';
                        }

                        if (isset($value['semestre'])) {
                            $course->cycle = isset($value['semestre']) ? $value['semestre'] : null;;
                        }

                        $course->university_law = isset($value['university_law']) ? $value['university_law'] : null;
                        $course->area_knowledge_id     = isset($value['area_knowledge_id']) ? $value['area_knowledge_id'] : null;
                        $course->curricula_id     = $curriculaAPI->id;

                        $course->save();
                        $count++;
                    }
                }
                $this->notify('Curricula y Cursos(' . $count . ' de ' . count($courses['data']) . ') registrados exitosamente');
            }
        }
    }


    public function resetFilters()
    {
        $this->reset('filters');
    }
    private function getDataFromApi()
    {
        try {
            // sleep(20);
            $response = Http::timeout(10)->get($this->url);

            if ($response->ok()) {
                return $response->json();
            } else {
                throw new \Exception('Error en la solicitud a la API'); // Lanza una excepción en caso de error
            }
        } catch (\Illuminate\Http\Client\RequestException $exception) {
            $this->notify('El API demoró  en responder. Por favor, inténtalo de nuevo mas tarde.');
        }
    }
    private function getDataFromApiCourses($code)
    {

        try {
            // sleep(20);
            $response = Http::timeout(10)->get($this->urlCourses . $code);

            if ($response->ok()) {
                return $response->json();
            } else {
                throw new \Exception('Error en la solicitud a la API courses'); // Lanza una excepción en caso de error
            }
        } catch (\Illuminate\Http\Client\RequestException $exception) {
            $this->notify('El API demoró  en responder. Por favor, inténtalo de nuevo mas tarde.');
        }
    }
    public function render()
    {

        return view('livewire.show-curricula', [
            'curriculas' => $this->rows,
        ]);
    }
}
