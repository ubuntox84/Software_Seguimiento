<?php

namespace App\Http\Livewire;

use App\Models\Petition;
use App\Models\UserPetition;
use App\Models\Course;
use App\Models\Curricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormPetition extends Component
{
    use WithFileUploads;

    public Petition $petition;
    public $imagePetition;
    public $nameUploadPetition;
    public $imageVoucher;
    public $nameUploadVoucher;
    public $codePetition;
    public $subjectPetition;
    public $isDisabled = false;
    public $courses = [];
    public $curricula;
    public $course;

    public $courseSelect = [];
    public  $courseCounter = 0;



    public function mount(Petition $petition)
    {
        $this->petition = $petition;
        $this->curricula = Curricula::query()
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->where('state', 1) // Agregar una condición para currículas activas
            ->first();
        $this->courses = Course::query()
            ->where('curricula_id', $this->curricula->id)
            ->get();
        $this->course = Course::query()
            ->where('curricula_id', $this->curricula->id)
            ->first();
    }
    // protected $rules = [
    //     'imagePetition' => 'required|image|max:1024',
    //     'imageVoucher' => 'required|image|max:1024',
    //     'codePetition' => 'required',
    //     'subjectPetition' => 'required',
    //   'courseSelect' => ['sometimes', 'array', 'min:1'],

    // ];


    protected function rules()
    {
        $rules = [
            'imagePetition' => 'required|image|max:1024',
            'imageVoucher' => 'required|image|max:1024',
            'codePetition' => 'required',
            'subjectPetition' => 'required',
            'courseSelect' => ['sometimes', 'array',]
        ];

        if ( strtolower($this->petition->name) === 'paralelo') {
            $rules['courseSelect'][] = 'required';
            $rules['courseSelect'][] = 'min:2';
        }
        if (strtolower($this->petition->name) === 'dirigido') {
            $rules['courseSelect'][] = 'required';
            $rules['courseSelect'][] = 'min:1';
        }

        return $rules;
    }

    protected $messages = [

        'imagePetition.required' => 'El Archivo solicitud es obligatorio',
        'imagePetition.max' => 'El Archivo debe pesar menos que 10MB',
        'imagePetition.image' => 'El campo voucher debe ser una imagen.',

        'imageVoucher.required' => 'El Archivo voucher es obligatorio',
        'imageVoucher.max' => 'El Archivo debe pesar menos que 10MB',
        'imagePetition.image' => 'El campo solicitud debe ser una imagen.',

        'codePetition.required' => 'El código de la solicitud es obligatoria',
        'subjectPetition.required' => 'El asunto de la solicitud es obligatoria',
        'courseSelect.required' => 'Este campo es obligatorio',
        'courseSelect.min' => 'debe seleccionar al menos dos cursos',

    ];

    public function save()
    {
        $this->validate();
        try {
            // dd($this->petition->id);
            $this->isDisabled = true;
            $imagePetition = 'storage/' . $this->imagePetition->store('imagePetition', 'public');
            $imageVoucher = 'storage/' . $this->imageVoucher->store('imageVoucher', 'public');
            UserPetition::create([
                'state_petition' => 2,
                'code_petition' => $this->codePetition,
                'subject' => $this->subjectPetition,
                // 'processing_date'=>'',
                'processing_status' => 2,
                // 'observations'=>'',
                'voucher_imagen_path' => $imageVoucher,
                'courses' => $this->courseSelect,
                'petition_imagen_path' => $imagePetition,
                'user_petition_id' => Auth::user()->id,
                // 'user_processor'=>'',
                'petition_id' => $this->petition->id,
            ]);
            $this->notify('Solicitud realizada exitosamente!');
            $this->resetProperties();
            return redirect()->route('petition-list');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function resetProperties()
    {

        $this->reset(['imagePetition', 'imageVoucher', 'codePetition', 'subjectPetition']);
        // Will reset both the search AND the isActive property.


    }
    public function updatedImagePetition($value)
    {

        // $this->validate();
        $this->nameUploadPetition = $this->getNameImage($this->imagePetition);
        // dd($this->nameUploadPetition);
        // dd($this->nameUploadPetition);
        $this->notify('Solicitud cargada  exitosamente!');
    }
    public function updatedImageVoucher($value)
    {

        // $this->validate();
        $this->nameUploadVoucher = $this->getNameImage($this->imageVoucher);;
        // dd($this->nameUploadPetition);
        $this->notify('Voucher cargada exitosamente!');
    }

    public function getNameImage($value)
    {
        return '...' . substr($value->getClientOriginalName(), -10);
    }
    public function courseSelectAdd($course)
    {
        // Si $this->courseSelect no está inicializado como un array, puedes hacerlo aquí
        if (!is_array($this->courseSelect)) {
            $this->courseSelect = [];
        }
        foreach ($this->courseSelect as $item) {
            if ($item['course'] == $course) {
                $this->notify('El curso ya esta agregado');
                return;
            }
        }
        // Define el valor para 'name' en función del contador
        if ($this->courseCounter == 0) {
            $name = 'pre requisito solicitado';
        } else {
            $name = 'principal curso solicitado';
            // Si hay más de un curso principal, agrega el número
            if ($this->courseCounter > 1) {
                $name .= ' ' . $this->courseCounter;
            }
        }

        // Incrementa el contador
        $this->courseCounter++;

        // Define el nuevo elemento con 'name' adecuado y agrega el curso
        $newItem = ['name' => $name, 'course' => $course];

        if (strtolower($this->petition->name) == 'dirigido' && $this->courseCounter <= 1) {
            $this->courseSelect[] = $newItem;
        } elseif (strtolower($this->petition->name) == 'paralelo' && $this->courseCounter <= 2) {
            if (empty($this->courseSelect)) {
                $this->courseSelect[] = $newItem;
            } else {
                // Si ya hay elementos en el arreglo, agrega el nuevo elemento al final
                $this->courseSelect[] = $newItem;
            }
        } else {
            $this->notify('No es posible agregar mas cursos');
        }

        // usort($this->courseSelect, function ($a, $b) {
        //     return $a['course'] <=> $b['course'];
        // });
    }
    public function removeCourse($index)
    {
        if ($index == 0) {
            // Borra todo el array
            $this->courseSelect = [];
            $this->courseCounter = 0;
        } elseif (isset($this->courseSelect[$index])) {
            // Elimina el elemento en el índice especificado
            unset($this->courseSelect[$index]);
            // Reindexa el array para evitar índices vacíos
            $this->courseSelect = array_values($this->courseSelect);
            $this->courseCounter--;
        }
    }
    public function render()
    {
        return view('livewire.form-petition');
    }
}
