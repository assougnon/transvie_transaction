<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{


    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'prenom' => ['required', 'string', 'max:255',],
            'telephone' => ['nullable', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'poste' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024']
        ])->validateWithBag('updateProfileInformation');





        if (isset($input['photo'])) {

            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'prenom' => $input['prenom'],
                'telephone' => $input['telephone'],
                'adresse' => $input['adresse'],
                'poste' => $input['poste'],

            ])->save();
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
          'prenom' => $input['prenom'],
          'telephone' => $input['telephone'],
          'adresse' => $input['adresse'],
          'poste' => $input['poste'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

}