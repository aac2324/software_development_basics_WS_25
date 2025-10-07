<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;   
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);

        //create users with different roles
        \App\Models\User::factory()
            ->count(20)
            ->state(new Sequence(
                ['role' => 'host'],
                ['role' => 'host'],
                ['role' => 'host'],
                ['role' => 'host'],
                ['role' => 'host'],
                ...array_fill(0, 15, ['role' => 'user'])
            ))->create();

        // ✅ Importing Events via Command (Mapping is in app/Console/Commands/ImportEvents.php)
        \Artisan::call('import:events', [
            'file' => storage_path('app/events.csv'),
        ]);

        //create reviews for events
        \App\Models\Review::factory(20)->create();
    }
}
