<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Poem;

class PublishLatestPoem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poem:publish-latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds the latest poem and marks it as published';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $poem = Poem::latest()->first();

        if ($poem) {
            $poem->published = true;
            $poem->save();
            $this->info('El último poema ("' . $poem->title . '") ha sido marcado como publicado.');
        } else {
            $this->warn('No se encontraron poemas para publicar.');
        }

        return 0;
    }
}
