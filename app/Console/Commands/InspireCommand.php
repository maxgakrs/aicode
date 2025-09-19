<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InspireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire {name=Artisan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->comment('Success is not final, failure is not fatal: it is the courage to continue that counts.');

        return self::SUCCESS;
    }
}
