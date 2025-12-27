<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'Atatürk Faculty of Education',
            'Faculty of Dentistry',
            'Faculty of Pharmacy',
            'Faculty of Science and Letters',
            'Faculty of Fine Arts and Design',
            'Faculty of Nursing',
            'Faculty of Law',
            'Faculty of Economics and Administrative Sciences',
            'Faculty of Civil and Environmental Engineering',
            'Faculty of Theology',
            'Faculty of Communication',
            'Faculty of Architecture',
            'Faculty of Engineering',
            'Faculty of Health Sciences',
            'Faculty of Sports Sciences',
            'Faculty of Medicine',
            'Faculty of Tourism',
            'Faculty of Veterinary Medicine',
            'Faculty of Artificial Intelligence and Informatics',
            'Faculty of Agriculture',
        ];
        foreach ($faculties as $facultyName) {
            // Eğer daha önce eklenmemişse ekle (Benzersizliği korur)
            Faculty::firstOrCreate(['name' => $facultyName]);
    }}
}
