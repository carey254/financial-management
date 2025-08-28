<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employer;

class EmployerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and create default employers for each
        $users = User::all();
        
        $defaultEmployers = [
            [
                'name' => 'MACFLEX',
                'contact_person' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'default_rate' => null,
                'is_active' => true,
            ],
            [
                'name' => 'JUJA',
                'contact_person' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'default_rate' => null,
                'is_active' => true,
            ],
            [
                'name' => 'MERU',
                'contact_person' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'default_rate' => null,
                'is_active' => true,
            ],
        ];
        
        foreach ($users as $user) {
            foreach ($defaultEmployers as $employerData) {
                // Check if employer already exists for this user
                $existingEmployer = $user->employers()
                    ->where('name', $employerData['name'])
                    ->first();
                    
                if (!$existingEmployer) {
                    $user->employers()->create($employerData);
                    $this->command->info("Created employer {$employerData['name']} for user {$user->name}");
                } else {
                    $this->command->info("Employer {$employerData['name']} already exists for user {$user->name}");
                }
            }
        }
        
        $this->command->info('Employer seeding completed!');
    }
}
