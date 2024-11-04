<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Reset Password - Savannah')]
class ResetPasswordPage extends Component
{
    use LivewireAlert;

    #[Url]
    public $email;

    public $token;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('required|string|min:8|same:password')]
    public $password_confirmation;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate();
        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token
        ],
            function (User $user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            });
        $status === Password::PASSWORD_RESET ?
            $this->flash('success', 'Password Reset Successfully.',['position' => 'bottom-right','toast'=>'success' ], '/login') :
            $this->alert('error', 'Password Reset Failed. Try forget my password again.',['position' => 'top','toast'=>'error']);
        $this->reset();

    }

    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
