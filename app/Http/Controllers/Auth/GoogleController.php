<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::login($user);

        return redirect()->route('filament.admin.pages.dashboard');
    }

}
