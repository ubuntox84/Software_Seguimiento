<?php

namespace App\Http\Livewire;

use App\Exports\AreaKnowledgesExport;
use App\Exports\CoursesExport;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use Illuminate\Http\Request;
use App\Models\AreaKnowledge;
use App\Models\Course;
use App\Models\Curricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AreaKnowledgeController extends Component
{

    use WithPerPagePagination, WithSorting;


    public $showDeleteModal = false;
    public $showEditModalCourse = false;
    public $showModalPreRequisite = false;
    public $showModalAssignCourseArea = false;
    public $showFilters = false;
    public $sortAsc = false;
    public $selectPage = false;
    public $selectedCourses = [];
    public $selectAreas = [];
    public $curriculas = [];

    public $assignCourses = [];
    public $addCourseArea = [];
    public $selectCourseToAddArea = [];
    public $searchCourse = '';
    public $areaKnowledge_id = '';
    public $actividad_libre = false;

    public $selectAll = false;
    public $selected = [];

    public $curricula_id;
    public $search = '';
    public $filters = [
        'search' => '',
        'type_course' => '',
        'university_law' => '',
    ];
    public AreaKnowledge $areaKnowledge;
    public Course $course;
    protected $queryString = ['sorts', 'curricula_id'];

    public $showModalPre = false;
    public $coursePre;
    public $course_id;
    public $curriculaState;
    public $add_course_id;
    public $selectCourses = [];
    public $coursesPre;

    public $showModalDetailCourse = false;
    public $detailCourse;

    public $showEditModal = false;
    protected function rules()
    {
        return [
            //  area knowledge
            'areaKnowledge.name' => [
                'required',
                Rule::unique('area_knowledge', 'code')->ignore($this->areaKnowledge->id),

                'min:4',
                'max:100'
            ],
            'areaKnowledge.total_credits' => [
                'nullable',
                'numeric'
            ],
            'selectCourses' => [
                'required',
                Rule::exists('courses', 'id'),
                Rule::unique('prerequisites', 'prerequisite_id')
                    ->where(function ($query) {
                        $query->whereIn('prerequisite_id', $this->selectCourses)
                            ->where('course_id', $this->course_id);
                    })
                    ->ignore($this->id)
            ],
            //course

            'course.code' => [
                'required',
                Rule::unique('courses', 'code')->ignore($this->course->id),

                'min:2',
                'max:20'
            ],
            'course.name' => 'required|min:2|max:200',
            'course.theoretic_hour' => 'required',
            'course.practical_hour' => 'required',
            'course.prerequisite' => 'numeric',
            'course.cycle' => 'required',
            'course.credits' => 'required',
            'course.university_law' => 'required|in:' . collect(Course::UNIVERSITYLAW)->keys()->implode(','),
            'course.type_course' => 'required|in:' . collect(Course::TYPECOURSE)->keys()->implode(','),
            'course.area_knowledge_id' => 'exists:area_knowledge,id',


        ];
    }
    public function handleChange($value)
    {
        if (!in_array($value, $this->selectCourses)) {
            $this->selectCourses = [...$this->selectCourses, $value];
        }
        $this->add_course_id = '';
    }
    protected $messages = [
        //area_knowledge
        'areaKnowledge.name.required' => 'El  campo nombre es obligatorio',
        'areaKnowledge.name.unique' => 'Este campo nombre ya se encuentra registrado',
        'areaKnowledge.name.max' => 'Este campo nombre no debe tener mas de 200 caracteres',
        'areaKnowledge.name.min' => 'Este campo nombre debe tener mínimo 4 caracteres',

        //course
        'course.code.required' => 'El   Código es obligatorio',
        'course.code.unique' => 'El  Código ya se encuentra registrado',
        'course.code.max' => 'El  Código no debe tener mas de 20 caracteres',
        'course.code.min' => 'El  Código debe tener mínimo 1 caracteres',

        'course.name.required' => 'El  nombre es obligatorio',
        'course.name.max' => 'El  nombre no debe tener mas de 200 caracteres',
        'course.name.min' => 'El  nombre debe tener mínimo 2 caracteres',

        'course.practicalHour.required' => 'El    horas prácticas   es obligatorio',
        'course.theoreticalHour.required' => 'El  horas teóricas    es obligatorio',
        'course.cycle.required' => 'El  ciclo teóricas    es obligatorio',
        'course.credits.required' => 'El   crédito   es obligatorio',
        'course.university_law.required' => 'El   ley universitaria    es obligatorio',
        'course.typeCourse.required' => 'El   tipo de curso es obligatorio',

        'course.area_knowledge_id.required' => 'El  área de conocimiento es obligatorio',

        'selectCourses.unique' => 'Este curso ya está en la lista de requisitos previos.',
        'selectCourses.required' => 'El campo curso por agregar es obligatorio',
        'selectCourses.exists' => 'El campo curso es invalido',


    ];
    protected $listeners = ['refreshAreaknowledge' => '$refresh'];

    public function showModalPreR($id)
    {
        // dd($id);
        $this->coursesPre=Course::query()
                ->select('id', 'name', 'code', 'type_course', 'area_knowledge_id', 'curricula_id')
                ->where(function ($query) {
                    $query->where('curricula_id', $this->curricula_id)
                        ->orWhereNull('curricula_id')
                        ->orWhere('curricula_id', '');
                })->get();
        $this->coursePre = Course::find($id);
        $this->course_id = $id;
        // dd( $this->coursePre);
        $this->curriculaState = Curricula::find($this->curricula_id);
        $this->showModalPre = true;
    }
    public function removeSelectCourse($id)
    {

        $position = array_search($id, $this->selectCourses);
        if ($position !== false) {
            unset($this->selectCourses[$position]);
        }
    }

    public function savePre()
    {
        // dd($this->selectCourses);
        $validatedData = $this->validate(
            [
                'selectCourses' => [
                    'required',
                    Rule::exists('courses', 'id'),
                    Rule::unique('prerequisites', 'prerequisite_id')
                        ->where(function ($query) {
                            $query->whereIn('prerequisite_id', $this->selectCourses)
                                ->where('course_id', $this->course_id);
                        })
                        ->ignore($this->id)
                ],

            ],

        );
        $course = Course::find($this->course_id);
        $course->prerequisites()->attach($this->selectCourses);
        $this->notify('Se agregaron los cursos prerrequisitos  con Éxito!');
        //   $this->render();
        $this->add_course_id = '';
        $this->coursePre = Course::select('id','code','name')->find($this->course_id);
        $this->selectCourses = [];
        $this->emit('refresh');
    }
    public function deletePrerequisite($id)
    {
        $course = Course::find($this->course_id);
        $course->prerequisites()->detach($id);
        $this->coursePre = Course::find($this->course_id);
        $this->notify('Prerequisito eliminado  con Éxito!');
        $this->emitSelf('refresh');
    }
    public function updatedSelectPage($value)
    {
        // if ($value) return $this->selected = AreaKnowledge::where('curricula_id', $this->curricula_id)->pluck('id')->map(fn ($id) => (string) $id);
        if ($value) {
        return $this->selected = AreaKnowledge::where(function ($query) {
    $query->where('curricula_id', $this->curricula_id)
        ->orWhere(function ($query) {
            $query->where('curricula_id', '')
                ->orWhereNull('curricula_id');
        });
})
        ->pluck('id')
        ->map(fn ($id) => (string) $id);
}

        $this->selectAll = false;
        $this->selected = [];
    }
    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function mount(Request $request)
    {
        $this->curriculas = Curricula::with('areasKnowledge')
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->get();
        if ($request->query('curricula_id')) {
            $this->curricula_id = $request->query('curricula_id');
        } else {

            if ($this->curriculas->where('state', 1)->first() === null) {
                Session::flash('notification', 'Agregue una curricula para continuar.');
                return redirect('/app');
            } else {
                $this->curricula_id = $this->curriculas->where('state', 1)->first()->id;
            }
        }
        $this->curriculaState = Curricula::find($this->curricula_id);
        $this->areaKnowledge = $this->makeBlankAreaKnowledge();
        $this->course = $this->makeBlankCourse();
    }
    public function deleteArea($id)
    {
        $area = AreaKnowledge::find($id);
        if ($area->courses()->exists()) {
            $this->notify('El Área de Conocimiento  ' . $area->name . ' tiene áreas relacionadas y no se puede eliminar.');
            return;
        }
        $area->delete();
        $this->notify('Área eliminada  con Éxito!');
        $this->getAreaKnowledge();
        $this->areaKnowledge = $this->makeBlankAreaKnowledge();
    }
    public function updatedShowEditModal()
    {
        $this->resetValidation();
    }
    public function showEditModalCourse()
    {
        $this->resetValidation();
    }


    public function updatedShowEditModalCourse()
    {

        $this->selectAreas = AreaKnowledge::whereHas('curriculas', function ($query) {
            $query->where('curriculas.id', $this->curricula_id);
        })
            ->orWhereNull('curricula_id')
            ->orWhere('curricula_id', '')
            ->with('courses')
            ->get();
        $this->resetValidation();
    }
    public function edit(AreaKnowledge $areaKnowledge)
    {

        if ($this->areaKnowledge->isNot($areaKnowledge)) $this->areaKnowledge = $areaKnowledge;
        $this->getAreaKnowledge();
        $this->showEditModal = true;
    }
    public function editCourse(Course $course)
    {
        $this->getAreaKnowledge();

        if ($this->course->isNot($course)) $this->course = $course;
        $this->showEditModalCourse = true;
    }
    public function getAreaKnowledge()
    {
        $this->selectAreas = AreaKnowledge::whereHas('curriculas', function ($query) {
            $query->where('curriculas.id', $this->curricula_id);
        })
            ->orWhereNull('curricula_id')
            ->orWhere('curricula_id', '')
            ->with('courses')
            ->get();
    }
    public function showPreRequisites(Course $course)
    {
        $this->showModalPreRequisite = true;
    }
    public function cancelFormPre()
    {

        $this->selectCourses = [];
        $this->showModalPre = false;
        $this->showModalDetailCourse = false;


        $this->resetValidation();
    }
    public function updatedshowModalPre()
    {
        // dd(empty($this->selectCourses));
        //   if (!$this->showModalPre && $this->selectCourses) {
        // }
        $this->cancelFormPre();
    }

    public function create()
    {
        $this->getAreaKnowledge();
        if ($this->areaKnowledge->getKey()) $this->areaKnowledge = $this->makeBlankAreaKnowledge();
        $this->showEditModal = true;
    }

    public function createCourse()
    {

        $this->selectAreas = AreaKnowledge::whereHas('curriculas', function ($query) {
            $query->where('curriculas.id', $this->curricula_id);
        })
            ->orWhereNull('curricula_id')
            ->orWhere('curricula_id', '')
            ->with('courses')
            ->get();
        if ($this->course->getKey()) $this->course = $this->makeBlankCourse();
        $this->showEditModalCourse = true;
    }
    public function assignCourseArea()
    {
        $this->selectAreas = AreaKnowledge::where('curricula_id', $this->curricula_id)
            ->orWhereNull('curricula_id')
            ->orWhere('curricula_id', '')
            ->get();
        $this->loadCourses();
        $this->showModalAssignCourseArea = true;
    }
    public function loadCourses()
    {
        $this->assignCourses = Course::query()->select('id', 'code', 'name', 'curricula_id')
            ->where(function ($query) {
                $query->where('curricula_id', $this->curricula_id)
                    ->orWhereNull('curricula_id')
                    ->orWhere('curricula_id', '');
            })
            ->when(strlen($this->searchCourse) >= 3, function ($query) {
                return $query->where('name', 'like', '%' . $this->searchCourse . '%')
                    ->orWhere('code', 'like', '%' . $this->searchCourse . '%');
            })->get();
    }
    public function addCourseToArea($course)
    {
        if (!in_array($course['id'], array_column($this->selectCourseToAddArea, 'id'))) {
            // Agregar el curso al array
            try {

                $course = Course::select('id', 'code', 'name', 'curricula_id')->findOrFail($course['id']);

                $this->selectCourseToAddArea[] = $course;
                $this->notify('Curso ' . $course['name'] . ' agregado!');
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->notify('El curso no existe en nuestros registros ' . $e);
            }
            // Puedes utilizar $this->cursosArray para realizar acciones adicionales o
            // emitir eventos que actualicen otros componentes en tu aplicación
        } else {
            $this->notify('El curso ya ha sido agregado...!');
        }
    }
    public function removeCourseToAreaAssign($id)
    {
        $this->selectCourseToAddArea = array_filter($this->selectCourseToAddArea, function ($curso) use ($id) {
            return $curso['id'] != $id;
        });
    }
    public function showDetailCourse($id)
    {
        $this->detailCourse = Course::with('areaKnowledges:id,name', 'prerequisites:id,code,name', 'curriculas:id,name')->where('id', $id)->first();
        $this->showModalDetailCourse = true;
    }
    public function saveAssignCourseArea()
    {
        if (empty($this->selectCourseToAddArea)) {
            return $this->notify('Los  cursos ha agregar están vacíos. Agrega al menos un curso.');
        } elseif ($this->areaKnowledge_id === null || $this->areaKnowledge_id === '') {
            return $this->notify('Selecciona un Área de Conocimiento');
        } else {
            foreach ($this->selectCourseToAddArea as $course) {
                Course::where('id', $course['id'])->update(['area_knowledge_id' => $this->areaKnowledge_id]);
            }
            $this->notify('Áreas de Conocimiento asignadas a cursos correctamente!!');
            $this->selectCourseToAddArea = [];
            $this->areaKnowledge_id = '';
        }
    }

    public function makeBlankAreaKnowledge()
    {
        return AreaKnowledge::make(['date' => now()]);
    }
    public function makeBlankCourse()
    {
        return Course::make(['date' => now()]);
    }

    public function deleteSelected()
    {
        if ($this->selectedCourses) {
            $deleteCount = Course::whereIn('id', $this->selectedCourses)->count();
            Course::whereIn('id', $this->selectedCourses)->delete();
            $this->selectedCourses = [];
            $this->selectAll = [];
            $this->selectPage = false;
            $this->emitSelf('refreshAreaknowledge');
            $this->showDeleteModal = false;
            $this->course = $this->makeBlankCourse();
            $this->notify('has eliminado  ' . $deleteCount . ' cursos');
        } else {

            $count = 0;
            foreach ($this->selected as $id) {
                $areas = AreaKnowledge::findOrFail($id);

                // Verificar si existe al menos un cursos relacionado
                if ($areas->courses()->exists()) {
                    $this->notify('El Área de Conocimiento  ' . $areas->name . ' tiene áreas relacionadas y no se puede eliminar.');
                    continue;
                }

                $areas->delete();
                $count++;
            }
            // AreaKnowledge::whereIn('id', $this->selected)->delete(); 
            $this->selected = [];
            $this->selectAll = [];
            $this->selectPage = false;
            $this->emitSelf('refreshAreaknowledge');
            $this->showDeleteModal = false;
            $this->notify('has eliminado  ' . $count . ' áreas de conocimiento');
        }
    }

    public function searchAreaCourse()
    {
        $this->render();
    }
    public function exportSelected()
    {

        if (!empty($this->selected)) {
            if (is_object($this->selected)) {
                return (new AreaKnowledgesExport($this->selected->toArray()))->download('área_conocimiento.xlsx');
            } else {
                return (new AreaKnowledgesExport($this->selected))->download('área_conocimiento.xlsx');
            }
        } else {
            return  $this->notify('Seleccione una Fila');
        }
    }
    public function exportCurso()
    {
        if (!empty($this->selectedCourses)) {
            return (new CoursesExport($this->selectedCourses))->download('cursos.xlsx');
        } else {
            return  $this->notify('Seleccione una Fila');
        }
    }


    public function toggleShowFilters()
    {
        $this->showFilters = !$this->showFilters;
    }


    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function save()
    {
       
        if($this->actividad_libre){
            $curricula_id = null;
        }
        else{
            $curricula_id= $this->curricula_id;
        }
        $validatedData = $this->validate(
            [
                'areaKnowledge.name' => [
                    'required',
                    Rule::unique('area_knowledge', 'name')->ignore($this->areaKnowledge->id),

                    'min:4',
                    'max:100'
                ],
                'areaKnowledge.total_credits' => [
                    'nullable',
                    'numeric'
                ],

            ],

        );

        if ($this->areaKnowledge->id !== null) {
            $this->areaKnowledge->save();
            //$this->showEditModal = false;
            // $this->resetValidation();
            //  $this->areaKnowledge = $this->makeBlankAreaKnowledge(); 
            $this->getAreaKnowledge();

            $this->notify('Área Actualizada con éxito!!');
        } else {
            $curricula = Curricula::find($this->curricula_id);
            if ($curricula && $curricula->state == true) {
                $this->areaKnowledge->curricula_id = $curricula_id;
                $this->areaKnowledge->save();
                $this->getAreaKnowledge();
                //$this->showEditModal = false;
                $this->areaKnowledge = $this->makeBlankAreaKnowledge();
                $this->notify('Área  Creada con éxito!');
            } else {
                $this->notify('la curricula esta desactivada!');
            }
        }
        $this->actividad_libre=false;
    }


    public function saveCourse()
    {
        if($this->course->type_course !== 'actividad_libre'){

            $curricula_id = $this->curricula_id;
        }
        else{
            $curricula_id=null;
        }

        $rules = [
            'course.code' => [
                'required',
                Rule::unique('courses', 'code')->ignore($this->course->id),
                'min:2',
                'max:20'
            ],
            'course.name' => 'required|min:2|max:200',
            'course.theoretic_hour' => 'required',
            'course.practical_hour' => 'required',
            'course.credits' => 'required',
            'course.prerequisite' => 'numeric|nullable',
            'course.university_law' => 'required|in:' . collect(Course::UNIVERSITYLAW)->keys()->implode(','),
            'course.type_course' => 'required|in:' . collect(Course::TYPECOURSE)->keys()->implode(','),
            'course.area_knowledge_id' => 'required|exists:area_knowledge,id',
            'curricula_id' => $this->course->type_course !== 'actividad_libre' ? 'required' : '',
        ];

        if ($this->course->type_course !== 'actividad_libre' && $this->course->type_course!=='electivo') {
            $rules['course.cycle'] = 'required';
        }

        $validatedData = $this->validate($rules);
        if ($this->course->id !== null) {
            $this->course->save();
            $this->showEditModalCourse = false;
            $this->notify('Curso Actualizado con éxito!!');
        } else {
            $this->course->curricula_id =$curricula_id;
            $this->course->save();
            $this->showEditModalCourse = false;
            $this->course = $this->makeBlankCourse();
            $this->notify('Curso  Creado con éxito!');
        }
    }


    public function render()
    {
        return view('livewire.area-knowledge-view', [
            'courses' => Course::query()
                ->select('id', 'name', 'code', 'type_course', 'area_knowledge_id', 'curricula_id')
                ->where(function ($query) {
                    $query->where('curricula_id', $this->curricula_id)
                        ->orWhereNull('curricula_id')
                        ->orWhere('curricula_id', '');
                })
                ->when($this->filters['type_course'], function ($query, $typeCourse) {
                    return $query->where('type_course', $typeCourse);
                })
                ->when($this->filters['university_law'], function ($query, $universityLaw) {
                    return $query->where('university_law', $universityLaw);
                })
                ->when(strlen($this->filters['search']) >= 3, function ($query) {
                    return $query->where(function ($query) {
                        $search = $this->filters['search'];
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('code', 'like', '%' . $search . '%')
                            ->orWhereHas('areaKnowledges', function ($query) use ($search) {
                                $query->where('name', 'like', '%' . $search . '%');
                            });
                    });
                })
                ->with('areaKnowledges:id,name,curricula_id')
                // ->with(['areaKnowledges' => function ($query) {
                //     $query
                //         ->where('curricula_id', $this->curricula_id)
                //         ->orWhereNull('curricula_id')
                //         ->orWhere('curricula_id', '');
                // }])
                ->groupBy('courses.id')
                ->orderByRaw("CASE WHEN curricula_id IS NOT NULL AND curricula_id <> '' THEN 1 ELSE 2 END")
                // ->orderByRaw("CASE WHEN curricula_id IS NOT NULL AND curricula_id <> '' THEN 1 ELSE 2 END, name")
                ->get(),

        ]);
    }
}
