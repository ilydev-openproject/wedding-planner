<?php

// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryTemplates = [
            // Kategori Vendor
            ['name' => 'Dekorasi', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'Catering', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'WO (Wedding Organizer)', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'Dokumentasi', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'MC & Hiburan', 'is_for_vendor' => true, 'is_for_budget' => false],

            // Kategori Budget
            ['name' => 'Souvenir', 'is_for_vendor' => false, 'is_for_budget' => true],
            ['name' => 'Transportasi', 'is_for_vendor' => false, 'is_for_budget' => true],
            ['name' => 'Venue', 'is_for_vendor' => false, 'is_for_budget' => true],
            ['name' => 'Percetakan Undangan', 'is_for_vendor' => false, 'is_for_budget' => true],

            // Kategori untuk keduanya
            ['name' => 'Makeup Artist', 'is_for_vendor' => true, 'is_for_budget' => true],
        ];

        $users = User::all();

        foreach ($users as $user) {
            foreach ($categoryTemplates as $template) {
                Category::create([
                    'user_id' => $user->id,
                    'name' => $template['name'],
                    'is_for_vendor' => $template['is_for_vendor'],
                    'is_for_budget' => $template['is_for_budget'],
                ]);
            }
        }
    }
}
