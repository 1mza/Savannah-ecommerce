<?php

namespace App\Livewire\Auth;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login - Savannah')]
class LoginPage extends Component
{
    use LivewireAlert;

    #[Validate('required|email|exists:users,email')]
    public $email;
    #[Validate('required|string|min:8')]
    public $password;

    public function login()
    {
        $this->validate();
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->flash('success', 'Logged In Successfully.', [
                'position' => 'bottom-right',
                'timer' => 3000,
                'toast' => true,
            ], '/');
        } else {
            $this->alert('error', 'Wrong email or password!',
                [
                    'position' => 'top',
                    'timer' => 3000,
                    'toast' => true,
                ]);
        }

    }

    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
