<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'nama' => 'Obat',
            'kode' => 'KGT001',
        ]);
        Category::create([
            'nama' => 'Alkes',
            'kode' => 'KGT002',
        ]);
        Category::create([
            'nama' => 'Matkes',
            'kode' => 'KGT003',
        ]);
        Category::create([
            'nama' => 'Umum',
            'kode' => 'KGT004',
        ]);
        Category::create([
            'nama' => 'ATK',
            'kode' => 'KGT005',
        ]);
    }
}
