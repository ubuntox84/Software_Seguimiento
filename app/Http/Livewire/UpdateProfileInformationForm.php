<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];
    public $selectedRoles = [];
    public $faculties;
    public $departments;
    public $roles;

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Determine if the verification email was sent.
     *
     * @var bool
     */
    public $verificationLinkSent = false;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->faculties = Faculty::all();
        $this->departments = Department::select('id','name')->where('faculty_id',Auth::user()->faculty_id)->get();
        $this->roles=Role::all();
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->selectedRoles = Auth::user()->roles()->pluck('id')->toArray();
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return void
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        // dd($this->state);
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state,
                $this->selectedRoles

        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }
        public function addRole($id){
             
            if (in_array($id,$this->selectedRoles)) {
                unset($this->selectedRoles[array_search($id, $this->selectedRoles)]);
            } 
            else{
        $this->selectedRoles = [...$this->selectedRoles, $id];

    }
        }
    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Auth::user()->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
    }
    public function selectDepartments(){
        // dd(intval($this->state['faculty_id']));
        $this->departments=Department::where('faculty_id',intval($this->state['faculty_id']))->get();
        if(count($this->departments)==0){
            $this->state['department_id']='';
        }
    }

    /**
     * Sent the email verification.
     *
     * @return void
     */
    public function sendEmailVerification()
    {
        Auth::user()->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // dd('ddffd');
        return view('profile.update-profile-information-form');
    }
}
