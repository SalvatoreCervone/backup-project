<?php

namespace SalvatoreCervone\BackupProject\Commands;

use Illuminate\Console\Command;
use SalvatoreCervone\BackupProject\Facades\BackupProject;

class BackupProjectCommand extends Command
{
    public $signature = 'backup-project:backup';

    public $description = 'Backup project';

    public function handle(): int
    {

        BackupProject::backup();
        $this->info('Database backup completed successfully.');

        return self::SUCCESS;
    }
}
