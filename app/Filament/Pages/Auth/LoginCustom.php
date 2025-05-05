<?php

namespace App\Filament\Pages\Auth;

use App\Models\Category;
use Filament\Pages\Page;
use Illuminate\View\View;
use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class LoginCustom extends Login
{
    protected function getHeader(): ?View
    {
        return view('components.google-login');
    }


    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        \Filament\Forms\Components\View::make('components.google-login'),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent()
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label(__('filament-panels::pages/auth/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        $user = auth()->user();

        if ($user && $user->created_at->equalTo($user->updated_at)) {
            \App\Models\Category::insertDefaultFor($user);
        }

        return $response;
    }

}
