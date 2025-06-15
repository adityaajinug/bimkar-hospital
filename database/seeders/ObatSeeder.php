<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Tablet 500mg',
                'harga' => 3000,
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Kapsul 250mg',
                'harga' => 5000,
            ],
            [
                'nama_obat' => 'Salbutamol',
                'kemasan' => 'Sirup 2mg/5ml',
                'harga' => 7500,
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Tablet 10mg',
                'harga' => 4000,
            ],
        ];

        foreach($obats as $row) {
            Obat::create($row);
        }
        
    }
}
