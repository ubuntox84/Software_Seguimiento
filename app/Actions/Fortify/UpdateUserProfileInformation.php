<?php

namespace App\Actions\Fortify;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Symfony\Component\Console\Input\Input;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    protected $messages = [
        'faculty_id.required' => 'El  campo Facultad es obligatorio',
        'code.required' => 'El  campo Código es obligatorio',
    ];
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */

    // dd($faculties);


    public function update(User $user, array $input, array $rolesIds): void
    {
        //    dd($input['department_id']);
        $department_id = null;
        if (isset($input['department_id']) && $input['department_id'] !== '') {
            $department_id = (int) $input['department_id'];
        }
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:10'],
            'faculty_id' => ['required', 'numeric', Rule::exists('faculties', 'id')],
            'department_id' => ['nullable', 'numeric', Rule::exists('departments', 'id')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ], $this->messages)->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'code' => $input['code'],
                'surname' => $input['surname'],
                'faculty_id' => $input['faculty_id'],
                'department_id' => $department_id,
            ])->save();

            $user->syncRoles($rolesIds);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
