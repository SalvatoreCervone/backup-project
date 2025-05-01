# Laravel Backup Project

![laravel backup database](https://github.com/SalvatoreCervone/backup-project/blob/main/.github/images/backup-project.png)

With this package you would backup folder of more of yours projects.

## Config file

This is a config file
```
 'listpathbackup' => [
        [
            /** The name of the backup project. */
            'name' => env('BACKUP_PROJECT_NAME', 'Backup Project'),

            /** The sorce path of the backup.  */
            'sorce_path' => '/your/path/to/source', // Substitute with the actual source directory

            /** The path where the backup files will be stored.  */
            'backup_path' => env('BACKUP_PROJECT_PATH', storage_path('app/backup')),

            /** The path where the backup logs will be stored.   */
            'log_path' => env('BACKUP_PROJECT_LOG_PATH', storage_path('logs/backup_project.log')),

            /** The maximum number of backup files to keep.     */
            'max_backups' => env('BACKUP_PROJECT_MAX_BACKUPS', 5),

            /** The maximum size of each backup file in megabytes. */
            'max_size' => env('BACKUP_PROJECT_MAX_SIZE', 100),

            /** The backup frequency (in minutes).    */
            'backup_frequency' => env('BACKUP_PROJECT_FREQUENCY', 60),

            /** The backup retention period (in days). */
            'backup_retention' => env('BACKUP_PROJECT_RETENTION', 30),

            /** The backup compression method.  */
            'compression' => env('BACKUP_PROJECT_COMPRESSION', 'zip'),

            /** The backup encryption method.  */
            'encryption' => env('BACKUP_PROJECT_ENCRYPTION', false),

            /** The encryption key.  */
            'encryption_key' => env('BACKUP_PROJECT_ENCRYPTION_KEY', 'your-encryption-key'),

            /** The encryption cipher.  */
            'encryption_cipher' => env('BACKUP_PROJECT_ENCRYPTION_CIPHER', 'AES-256-CBC'),

            /** The backup notification email address. */
            'notification_email' => env('BACKUP_PROJECT_NOTIFICATION_EMAIL', 'your-mail@gmail.com'),
        ]
    ]
```
You can insert multi projects sorces with multi destinations and multi parameters for all projects.

## For install:
```
composer require salvatorecervone/backup-project
```

## For publish config 
```
php artisan vendor:publish --tag="backup-project-config"
```

## For test use 

```
php artisan tink
```
after
```
BackupProject::backup()
```

## Artisan command

You find a command artisan for lunch backup for CLI or insert in schedulate
```
php artisan backup-project:backup
```

## Schedule

If you schedule this, for example, every day you can use default laravel schedulate
```
App\Console\Kernel.php

 protected function schedule(Schedule $schedule)    {
    $schedule->command('backup-project:backup')->dailyAt('3:00')
}

```

## Credits

- [Salvatore](https://github.com/salvatorecervone)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
