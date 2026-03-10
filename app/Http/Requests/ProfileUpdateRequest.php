<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // TAMBAHKAN VALIDASI PASSWORD DI SINI
            'password' => [
                'nullable', 
                'confirmed', 
                Password::defaults() // Standar Laravel: min 8 karakter
            ],

            'no_hp_ortu' => [
                'nullable', 
                'string', 
                'max:20', 
                'regex:/^([0-9\s\-\+\(\)]*)$/'
            ],

            'alamat' => [
                'nullable', 
                'string', 
                'max:1000'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'no_hp_ortu' => 'Nomor HP Orang Tua',
            'alamat' => 'Alamat Lengkap',
            'password' => 'Kata Sandi Baru',
        ];
    }
}