<?php

namespace App\Filament\Pages\Auth;

use components;
use Filament\Pages\Page;
use Illuminate\View\View;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegistrationCustom extends Register
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        \Filament\Forms\Components\View::make('components.google-login'),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->label(__('filament-panels::pages/auth/register.form.name.label'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/register.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique($this->getUserModel())
            ->validationMessages([
                'unique' => 'Email ini sudah pernah di gunakan'
            ]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->dehydrateStateUsing(fn($state) => Hash::make($state))
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'))
            ->validationMessages([
                'same' => 'Password tidak sesuai',
                'min.string' => 'Password minimal 8 karakter dan gunakan kombinasi huruf & angka',
            ]);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->dehydrated(false);
    }
}
