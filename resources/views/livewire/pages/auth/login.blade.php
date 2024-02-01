<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    #[Rule(['required', 'string', 'email'])]
    public string $email = 'superadmin@gmail.com';

    #[Rule(['required', 'string'])]
    public string $password = 'superadmin';

    #[Rule(['boolean'])]
    public bool $remember = true;

    public ?string $role = null;

    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!auth()->attempt($this->only(['email', 'password'], $this->remember))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        session()->regenerate();

        $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    // public function loginAs(string $role)
    // {
    //     $this->email = $role . '@gmail.com';
    //     $this->password = $role;

    //     $this->role = $role;
    // }
}; ?>

<div>
    <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">

        <x-application-logo />

        {{-- form --}}
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="login">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input wire:model="password" id="password" class="block w-full mt-1" type="password"
                        name="password" required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="remember" id="remember" type="checkbox"
                            class="border-gray-300 rounded shadow-sm text-primary focus:ring-primary/80"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button.primary class="ml-3">
                        {{ __('Log in') }}
                    </x-button.primary>
                </div>
            </form>
        </div>

        {{-- <div class="mt-10 space-x-3">
            <span>Login as: </span>

            <span class="inline-flex -space-x-px overflow-hidden bg-white border rounded-md shadow-sm">
                <button wire:click="loginAs('superadmin')" @class([
                    'inline-block px-4 py-2 text-sm font-medium duration-200 ease-in-out hover:bg-primary hover:text-white focus:relative',
                    'bg-primary text-white' => $role == 'superadmin',
                ])>
                    {{ __('Super admin') }}
                </button>

                <button wire:click="loginAs('manager')" @class([
                    'inline-block px-4 py-2 text-sm font-medium duration-200 ease-in-out hover:bg-primary hover:text-white focus:relative',
                    'bg-primary text-white' => $role == 'manager',
                ])>
                    {{ __('Manager') }}
                </button>

                <button wire:click="loginAs('cashier')" @class([
                    'inline-block px-4 py-2 text-sm font-medium duration-200 ease-in-out hover:bg-primary hover:text-white focus:relative',
                    'bg-primary text-white' => $role == 'cashier',
                ])>
                    {{ __('Cashier') }}
                </button>
            </span>
        </div> --}}
    </div>
</div>
