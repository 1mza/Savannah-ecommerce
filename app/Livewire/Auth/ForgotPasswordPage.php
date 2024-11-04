<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Forget Password - Savannah')]
class ForgotPasswordPage extends Component
{
    use LivewireAlert;
    #[Validate('bail|required|email|exists:users,email')]
    public $email;
    public function forgetPassword(){
        $this->validate();
        Password::sendResetLink(['email'=>$this->email]);
        $this->alert('success','Your reset password link has been sent to your email successfully.',[
            'position' => 'top',
            'timer' => 5000,
        ]);
        $this->reset();
    }
    public function render()
    {
        return view('livewire.auth.forgot-password-page');
    }
}
