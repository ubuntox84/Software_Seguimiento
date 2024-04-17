<?php

namespace App\Http\Livewire;

use App\Csv;
use App\Imports\AreaKnowledgesImport;
use App\Imports\CoursesImport;
use App\Imports\FreeActivityCoursesImport;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

use Maatwebsite\Excel\Facades\Excel;

class ImportCourses extends Component
{

    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $columns;
    public $nameUpload;
    public $curricula_id;
    public $importCourseArea;
    public $importFreeActivityCourses;



    protected $rules = [
        'upload' => 'required|mimes:xlsx|max:10024',

    ];


    protected $messages = [

        'upload.required' => 'El Archivo excel es obligatorio',
        'upload.mimes' => 'El Archivo de ser en formato xlsx',
        'upload.mimes' => 'El Archivo debe pesar menos que 10MB',


    ];
    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:xlsx'],
            [
                'mimes' => 'El Archivo de ser en formato xlsx',
            ],

        )->validate();
    }
    public function updatedShowModal()
    {
        if (!$this->showModal) {
            $this->importCourseArea = '';
            $this->upload = '';
            $this->nameUpload = '';
        }
    }


    public function import()
    {

        $this->validate();
        if (strcmp($this->importCourseArea, "area") === 0) {
           return $this->importAreaKnowledge($this->curricula_id);
        } elseif (strcmp($this->importCourseArea, "course") === 0) {
           return  $this->importCourse($this->curricula_id);
        } elseif (strcmp($this->importCourseArea, "both") === 0) {
            return $this->importAreaKnowledgeAndCourse($this->curricula_id);
        }elseif (strcmp($this->importCourseArea, "freeActivity") === 0) {
            return $this->importForFreeActivityCourse();
        }

    }
    public function importCourse($id)
    {
        $import = new CoursesImport($id);

        Excel::import($import, $this->upload);
        $this->emit('refreshAreaknowledge');
        $this->notify('Importado ' . $import->getRowCount() . ' cursos!');
       $this->cleanField();
    }
    public function importAreaKnowledge($id)
    {
        $import = new AreaKnowledgesImport($id);

        Excel::import($import, $this->upload);
        $this->emit('refreshAreaknowledge');
        $this->notify('Área de Conocimiento importado con éxito!');
       $this->cleanField();

    }
     public function importAreaKnowledgeAndCourse($id)
    {
        $importArea = new AreaKnowledgesImport($id);
        Excel::import($importArea, $this->upload);
         
        $importCourse = new CoursesImport($id);
        Excel::import($importCourse, $this->upload);
        $this->emit('refreshAreaknowledge');
        $this->notify('Importado ' . $importCourse->getRowCount() . ' cursos!');
        $this->cleanField();

    }
     public function importForFreeActivityCourse()
    {
        
         
        $freeActivityCourse = new FreeActivityCoursesImport();
        Excel::import($freeActivityCourse, $this->upload);
        $this->emit('refreshAreaknowledge');
        $this->notify('Importado ' . $freeActivityCourse->getRowCount() . ' cursos de actividad libre y '.$freeActivityCourse->getAreaCount().' Áreas de Conocimientos'  );
        $this->cleanField();

    }
    public function cleanField(){
        $this->upload='';
        $this->importCourseArea='';
        $this->nameUpload='';
    }
    public function updatedUpload($value)
    {
        $this->nameUpload = $this->upload->getClientOriginalName();
    }

    public function cancelForm()
    {
        $this->showModal = false;
        $this->reset();
    }
}
