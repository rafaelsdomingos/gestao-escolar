<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\AcademicCoordination;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\CourseModality;
use App\Enums\Ser;
use App\Enums\RaceColor;
use App\Enums\Gender;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ])->assignRole('super_admin');

        User::factory()->create([
            'name' => 'Professor 1',
            'email' => 'professor1@example.com',
        ]);

        User::factory()->create([
            'name' => 'Professor 2',
            'email' => 'professor2@example.com',
        ]);

        User::factory()->create([
            'name' => 'Professor 3',
            'email' => 'professor3@example.com',
        ]);

        AcademicCoordination::factory()->create([
            'name' => 'Escola Pública de Audiovisual',
            'code' => 'EPAV',
            'coordinator' => 'Cris Francelino',
            'phone' => '85988879658',
            'email' => 'epav@viladasartesfortaleza.com',
        ]);

        AcademicCoordination::factory()->create([
            'name' => 'Escola Pública de Dança',
            'code' => 'EPD',
            'coordinator' => 'Izabel Souza',
            'phone' => '85988879700',
            'email' => 'epd@viladasartesfortaleza.com',
        ]);

        AcademicCoordination::factory()->create([
            'name' => 'Escola Pública de Teatro',
            'code' => 'EPT',
            'coordinator' => 'João Silva',
            'phone' => '85988879888',
            'email' => 'ept@viladasartesfortaleza.com',
        ]);

        AcademicCoordination::factory()->create([
            'name' => 'Escola Pública de Circo',
            'code' => 'EPC',
            'coordinator' => 'Francisco de Souza',
            'phone' => '85988879588',
            'email' => 'epav@viladasartesfortaleza.com',
        ]);

        Course::factory()->create([
            'academic_coordination_id' => 1,
            'name' => 'Curso de Realização em Audiovisual',
            'modality' => CourseModality::PRESENCIAL,
        ]);

        Course::factory()->create([
            'academic_coordination_id' => 2,
            'name' => 'Curso de Formação Básica em Dança',
            'modality' => CourseModality::PRESENCIAL,
        ]);

        // Student::factory()->create([
        //     'registration_number' => 202600001,
        //     'name' => 'Patativa do Assaré',
        //     'nationality' => 'Brasileira',
        //     'birthplace' => 'Assaré',
        //     'birthdate' => '1909-03-05',
        //     'gender' => Gender::homemCis,
        //     'race_color' => RaceColor::branca,
        //     'ser' => Ser::ser1,
        //     'education_level' => 'Ensino Superior Completo'
        // ]);

        Student::factory(180)->create();
    }
}
