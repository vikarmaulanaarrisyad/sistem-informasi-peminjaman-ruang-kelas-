<?php

namespace App\Actions\Fortify;

use App\Models\Mahasiswa;
use App\Models\User;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();


        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'pass' => $input['password'],
                'username' => $input['nim'],
                'role_id' => 2
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'name' => $input['name'],
                'nim' => $input['nim'],
                'qrcode' => $input['nim'],
                'nomor_hp' => 0,
            ]);

            DB::commit();

            Session::flash('message', 'Profil berhasil diperbarui');
            Session::flash('success', true);
            
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
