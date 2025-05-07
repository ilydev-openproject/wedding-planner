<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use App\Http\Controllers\Controller;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
        if ($user->category()->count() === 0) {
            $categoryTemplates = [
                ['name' => 'Dekorasi', 'is_for_vendor' => true, 'is_for_budget' => false],
                ['name' => 'Catering', 'is_for_vendor' => true, 'is_for_budget' => false],
                ['name' => 'WO (Wedding Organizer)', 'is_for_vendor' => true, 'is_for_budget' => false],
                ['name' => 'Dokumentasi', 'is_for_vendor' => true, 'is_for_budget' => false],
                ['name' => 'MC & Hiburan', 'is_for_vendor' => true, 'is_for_budget' => false],
                ['name' => 'Souvenir', 'is_for_vendor' => false, 'is_for_budget' => true],
                ['name' => 'Transportasi', 'is_for_vendor' => false, 'is_for_budget' => true],
                ['name' => 'Venue', 'is_for_vendor' => false, 'is_for_budget' => true],
                ['name' => 'Percetakan Undangan', 'is_for_vendor' => false, 'is_for_budget' => true],
                ['name' => 'Makeup Artist', 'is_for_vendor' => true, 'is_for_budget' => true],
            ];

            foreach ($categoryTemplates as $template) {
                $user->category()->create($template);
            }
        }

        return redirect()->route('filament.admin.pages.dashboard');
    }

}
