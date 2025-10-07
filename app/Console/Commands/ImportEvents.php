<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\User;
use League\Csv\Reader;

class ImportEvents extends Command
{
    protected $signature = 'import:events {file=storage/app/events.csv}';
    protected $description = 'Import events from a CSV file and assign hosts automatically';

    public function handle()
    {
        $file = $this->argument('file');
        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return Command::FAILURE;
        }

        $csv = Reader::createFromPath($file, 'r');
        $csv->setDelimiter(';'); // ✅ Semikolon instead of comma
        $csv->setHeaderOffset(0);

        $hosts = User::where('role', 'host')->get();
        if ($hosts->isEmpty()) {
            $this->error('No hosts found. Make sure you have users with role=host.');
            return Command::FAILURE;
        }

        foreach ($csv as $record) {
            \App\Models\Event::create([
                'title' => $record['title'],
                'starts_at' => $record['starts_at'],
                'location' => $record['location'],
                'description' => $record['description'],
                'host_id' => $hosts->random()->id,
            ]);
        }

        $this->info('✅ Events imported successfully!');
        return Command::SUCCESS;
    }
}
