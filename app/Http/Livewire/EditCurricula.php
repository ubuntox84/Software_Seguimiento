<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use App\Models\Curricula;
use Livewire\Component;

class EditCurricula extends Component
{
    public $curricula;

    public $curricula_id;
    public $name;
    public $resolution;
    public $date_approved;
    public $date_active;
    public $date_inactive;
    
    protected function rules()
    {
        return [
           
            'name' => [
                'required',
                Rule::unique('curriculas')->ignore($this->curricula_id),

                'min:4',
                'max:200'
            ],
            'resolution' => [
                'required',
                Rule::unique('curriculas')->ignore($this->curricula_id),

                'min:4',
                'max:100'
            ],

            'date_approved' => 'required',
            'date_active' => 'required',
            'date_inactive' => 'required',
        ];
    }
    protected $messages = [
    
        'name.required' => 'El  campo es obligatorio',
        'name.unique' => 'Este campo ya se encuentra registrado',
        'name.max' => 'Este campo no debe tener mas de 200 caracteres',
        'name.min' => 'Este campo debe tener mínimo 4 caracteres',

        'resolution.required' => 'El  campo es obligatorio',
        'resolution.unique' => 'Este campo ya se encuentra registrado',
        'resolution.max' => 'Este campo no debe tener mas de 100 caracteres',
        'resolution.min' => 'Este campo debe tener mínimo 4 caracteres',

        'date_approved.required' => 'La fecha de aprobación  es obligatorio',
        'date_active.required' => 'La fecha activa es obligatorio',
        'date_inactive.required' => 'La fecha inactiva es obligatorio',
    ];

    protected $listeners = ['loadFormEdit'];

   

    public function loadFormEdit($id)
    {

        $curricula = Curricula::find($id);
        $this->curricula_id = $curricula->id;
        $this->name = $curricula->name;
        $this->resolution = $curricula->resolution;
        $this->date_approved = $curricula->date_approved;
        $this->date_active = $curricula->date_active;
        $this->date_inactive = $curricula->date_inactive;

    }
    public function updateCurriula()
    {
        $this->validate();
        $curricula = Curricula::findOrFail($this->curricula_id);

      
        $curricula->name = $this->name;
        $curricula->resolution = $this->resolution;
        $curricula->date_approved = $this->date_approved;
        $curricula->date_active = $this->date_active;
        $curricula->date_inactive = $this->date_inactive;

        $curricula->save();
        $this->emit('refreshCurricula');


        $this->emit('messageSuccess', 'Currícula actualizada con éxito!');
    }
    public function cancelForm()
    {$this->emit('closeModalEditCurso');  
       $this->resetValidation();
        $this->reset();
    }
    // public function cleanField()
    // {

    //     $this->curricula_id = '';
    //     $this->code = '';
    //     $this->name = '';
    //     $this->resolution = '';
    //     $this->date_approved = '';
    //     $this->date_active = '';
    //     $this->date_inactive = '';
    //     $this->resetValidation();
    // }

    public function render()
    {
        return view('livewire.edit-curricula');
    }
}
