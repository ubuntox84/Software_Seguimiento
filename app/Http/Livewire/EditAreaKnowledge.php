<?php

namespace App\Http\Livewire;

use App\Models\AreaKnowledge;
use Livewire\Component;

use Illuminate\Validation\Rule;

class EditAreaKnowledge extends Component
{
    public $areasKnowledge_id;
    public $code;
    public $name;

    protected $listeners = [
        'loadEditFormAreaKnowledge' => 'loadFormEdit',
        'cleanFieldEdit'=>'cancelForm'
    ];

    protected function rules()
    {
        return [
            'code' => [
                'required',
                Rule::unique('area_knowledge')->ignore($this->areasKnowledge_id),

                'min:1',
                'max:50'
            ],

            'name' => [
                'required',
                Rule::unique('area_knowledge')->ignore($this->areasKnowledge_id),

                'min:4',
                'max:100'
            ],
            
        ];
    }
    protected $messages = [
        'code.required' => 'El  campo es obligatorio',
        'code.unique' => 'Este campo ya se encuentra registrado',
        'code.max' => 'Este campo no debe tener mas de 100 caracteres',
        'code.min' => 'Este campo debe tener mínimo 4 caracteres',

        'name.required' => 'El  campo es obligatorio',
        'name.unique' => 'Este campo ya se encuentra registrado',
        'name.max' => 'Este campo no debe tener mas de 200 caracteres',
        'name.min' => 'Este campo debe tener mínimo 4 caracteres',

       
    ];

    public function loadFormEdit($id)
    {
        $areasKnowledgeLoad = AreaKnowledge::findOrFail($id);
        $this->areasKnowledge_id = $areasKnowledgeLoad->id;
        $this->code = $areasKnowledgeLoad->code;
        $this->name = $areasKnowledgeLoad->name;
    }
    
    public function updateAreaKnowledge()
    {
        $this->validate();
        $areasKnowledge = AreaKnowledge::find($this->areasKnowledge_id);

        $areasKnowledge->code = $this->code;
        $areasKnowledge->name = $this->name;
      
        $areasKnowledge->save();
        // $this->resetValidation();
        $this->emit('refreshCourse');
        $this->emit('messageSuccess', 'Área de Conocimiento actualizada con éxito!');
    }
    public function cancelFormArea(){
        $this->emit('closeModalEditArea');    
        $this->reset();
        $this->resetValidation();


    }
    public function render()
    {
        return view('livewire.edit-area-knowledge');
    }
}
