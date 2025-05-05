<?php

namespace Database\Seeders;

use create;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TaskTemplate;

class TaskTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'tradition' => 'Jawa',
                'title' => 'Beli Kotak Seserahan',
                'description' => 'Membeli kotak untuk seserahan pakaian, perhiasan, dan makanan.',
                'category' => 'seserahan',
                'default_due_offset' => 30,
            ],
            [
                'tradition' => 'Jawa',
                'title' => 'Siapkan Barang Seserahan',
                'description' => 'Menyiapkan pakaian, perhiasan, dan makanan untuk seserahan.',
                'category' => 'seserahan',
                'default_due_offset' => 14,
            ],
            [
                'tradition' => 'Jawa',
                'title' => 'Dekorasi Seserahan',
                'description' => 'Mengatur dekorasi untuk kotak seserahan.',
                'category' => 'seserahan',
                'default_due_offset' => 7,
            ],
            [
                'tradition' => 'Jawa',
                'title' => 'Persiapan Siraman',
                'description' => 'Menyiapkan perlengkapan untuk acara siraman.',
                'category' => 'siraman',
                'default_due_offset' => 7,
            ],
        ];
        foreach ($templates as $template) {
            TaskTemplate::create($template);
        }
    }
}
