<?php

// config for SalvatoreCervone/BackupProject
return [
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
];
