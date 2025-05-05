<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function insertDefaultFor($user): void
    {
        $categoryTemplates = [
            ['name' => 'Dekorasi', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'Catering', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'WO', 'is_for_vendor' => true, 'is_for_budget' => false],
            ['name' => 'Souvenir', 'is_for_vendor' => false, 'is_for_budget' => true],
            ['name' => 'Transportasi', 'is_for_vendor' => false, 'is_for_budget' => true],
            ['name' => 'Makeup Artist', 'is_for_vendor' => true, 'is_for_budget' => true],
        ];

        foreach ($categoryTemplates as $template) {
            static::firstOrCreate([
                'user_id' => $user->id,
                'name' => $template['name'],
            ], [
                'is_for_vendor' => $template['is_for_vendor'],
                'is_for_budget' => $template['is_for_budget'],
            ]);
        }
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'category_id');
    }

}
