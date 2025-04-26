<?php

namespace SalvatoreCervone\BackupProject;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use SalvatoreCervone\BackupProject\Commands\BackupProjectCommand;

class BackupProjectServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('backup-project')
            ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_backup_project_table')
            // ->hasCommand(BackupProjectCommand::class)
        ;
    }
}
