<?php

namespace App\Console\Commands;

use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:translations {count=100000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with translations for testing scalability.';

    public function handle()
    {
        $count = (int) $this->argument('count');
        $chunkSize = 5000;

        $this->info("Seeding {$count} translations...");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        ini_set('memory_limit', '1024M');

        DB::disableQueryLog();

        for ($i = 0; $i < $count; $i += $chunkSize) {
            $chunk = [];

            for ($j = 0; $j < $chunkSize && ($i + $j) < $count; $j++) {
                $chunk[] = [
                    'locale' => $this->getRandomLocale(),
                    'key' => 'key_' . ($i + $j + 1),
                    'value' => 'Translation value ' . ($i + $j + 1),
                    'tags' => json_encode(['mobile', 'web']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Translation::insert($chunk);

            $bar->advance(count($chunk));
        }

        $bar->finish();
        $this->info("\nSeeding completed successfully!");
    }

    private function getRandomLocale(): string
    {
        static $locales = ['en', 'fr', 'es', 'de'];
        return $locales[array_rand($locales)];
    }
}
