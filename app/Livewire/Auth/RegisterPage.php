<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Register - Savannah')]
class RegisterPage extends Component
{
    use LivewireAlert;

    #[Validate('required|string|max:255')]
    public $name;

    #[Validate('required|email|unique:users,email')]
    public $email;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('required|string|min:8|same:password')]
    public $password_confirmation;


    public function save()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        auth()->login($user);
        $this->flash('success', 'Registered Successfully.',['position' => 'bottom-right','toast'=>'success' ], '/');

    }


    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
