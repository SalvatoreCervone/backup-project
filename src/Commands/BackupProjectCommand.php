<?php

namespace SalvatoreCervone\BackupProject\Commands;

use Illuminate\Console\Command;

class BackupProjectCommand extends Command
{
    public $signature = 'backup-project';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
