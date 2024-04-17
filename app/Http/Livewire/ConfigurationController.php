<?php

namespace App\Http\Livewire;

use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigurationController extends Component
{
    use WithFileUploads;
    public Configuration $configuration;
    public $right_image;
    public  $left_image;
    public  $logo_path;
    // protected $rules = [
    //      'left_image' => 'required|image|max:1024', 
    //     'right_image' => 'required|image|max:1024', 
    //     'configuration.university' => 'required',
    //     'configuration.director' => 'required',
    //     'configuration.nameComission' => 'required',
    //     'configuration.abbreviation' => 'required',
    //     'configuration.agreement_number' => 'required',

    // ];
    public function rules()
    {
        $rules = [
            'configuration.university' => 'required',
            'configuration.city' => 'required',
            'configuration.director' => 'required',
            'configuration.commission_name' => 'required',
            'configuration.abbreviation' => 'required',
            'configuration.agreement_number' => 'required',
            'configuration.semester' => 'required',
            'configuration.president_name' => 'required',
        ];

        if (empty($this->configuration['left_image'])) {
            $rules['left_image'] = 'required|image|max:1024';
        }

        if (empty($this->configuration['right_image'])) {
            $rules['right_image'] = 'required|image|max:1024';
        }
        if (empty($this->configuration['logo_path'])) {
            $rules['logo_path'] = 'required|image|max:1024';
        }

        return $rules;
    }

    protected $messages = [
        'configuration.university' => 'El nombre de la universidad es obligatorio',
        'configuration.director' => 'El nombre del director es obligatorio',
        'configuration.commission_name' => 'El nombre de la comisión  es obligatorio',
        'configuration.abbreviation' => 'El campo abreviatura   es obligatorio',
        'configuration.agreement_number' => 'El campo número de acuerdo es obligatorio',
        'configuration.semester' => 'El campo semestre es obligatorio',
        'configuration.president_name' => 'El nombre del presidente es obligatorio',
        'left_image' => 'la imagen del encabezado es obligatorio',
        'right_image' => 'la imagen del encabezado es obligatorio',
        'logo_path' => 'la imagen del logo es obligatorio',
    ];

    public function mount()
    {
        $this->configuration = $this->getConfiguration();
    }


    public function getConfiguration()
    {
        $configuration = Configuration::where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->first();

        if (!$configuration) {
            $configuration = $this->makeBlankConfiguration();
        }
        return $configuration;
    }
    public function makeBlankConfiguration()
    {
        return Configuration::make(['date' => now()]);
    }

    public function submit()
    {
        if (!empty($this->left_image)) {
            $left_image = '';
            $right_image = '';
            $logo_path = '';
            $left_image = 'storage/' . $this->left_image->store('left_image', 'public');
            if (!empty($this->configuration->left_image)) {
                $this->deleteImageStorage($this->configuration->left_image);
            }
        } elseif (!empty($this->configuration->left_image)) {
            $left_image = $this->configuration->left_image;
        }
        if (!empty($this->right_image)) {
            $right_image = 'storage/' . $this->right_image->store('right_image', 'public');
            if (!empty($this->configuration->right_image)) {
                $this->deleteImageStorage($this->configuration->right_image);
            }
        } elseif (!empty($this->configuration->right_image && empty($this->right_image))) {
            $right_image = $this->configuration->right_image;
        }
         if (!empty($this->logo_path)) {
            $logo_path = 'storage/' . $this->logo_path->store('logo_image', 'public');
            if (!empty($this->configuration->logo_path)) {
                $this->deleteImageStorage($this->configuration->logo_path);
            }
        } elseif (!empty($this->configuration->logo_path && empty($this->logo_path))) {
            $logo_path = $this->configuration->logo_path;
        }


        $this->validate();


        $this->configuration->left_image =  $left_image;
        $this->configuration->right_image =  $right_image;
        $this->configuration->logo_path =  $logo_path;
        $this->configuration->faculty_id =  Auth::user()->faculty_id;
        $this->configuration->department_id =  Auth::user()->department_id;
        $this->configuration->save();

        //    Configuration::create([
        //     'university'=>$this->configuration->university,
        //     'director'=>$this->configuration->director,
        //     'nameComission'=>$this->configuration->nameComission,
        //     'abbreviation'=>$this->configuration->abbreviation,
        //     'agreement_number'=>$this->configuration->agreement_number,
        //     'imgLeft'=>$left_image,
        //     'imgRight'=>$right_image,
        //     'faculty_id'=>$this->configuration->faculty_id,
        //     'departmeyt_id'=>$this->configuration->departmeyt_id,
        //    ]);

        $this->notify('Solicitud realizada exitosamente!');
        $this->resetValidation();
        // Execution doesn't reach here if validation fails.


    }
    public function deleteImageStorage($pathPetition)
    {
        // dd($pathPetition);
        $petition_imagen_path = str_replace('storage/', '', $pathPetition);
        // $voucher_imagen_path = str_replace('storage/', '', $pathVoucher);

        if (Storage::disk('public')->exists($petition_imagen_path)) {
            Storage::disk('public')->delete($petition_imagen_path);
        }
    }
    public function render()
    {
        return view('livewire.configuration');
    }
}
