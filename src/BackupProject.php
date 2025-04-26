<?php

namespace SalvatoreCervone\BackupProject;

class BackupProject
{
    // Define the properties and methods for the BackupProject class here
    protected $name;
    protected $backupPath;
    protected $logPath;
    protected $maxBackups;
    protected $maxSize;
    protected $backupFrequency;
    protected $backupRetention;
    protected $compression;
    protected $encryption;
    protected $encryptionKey;
    protected $encryptionCipher;
    protected $notificationEmail;

    public function __construct()
    {
        // Initialize properties with default values or from configuration
        $this->name = config('backup-project.name');
        $this->backupPath = config('backup-project.backup_path');
        $this->logPath = config('backup-project.log_path');
        $this->maxBackups = config('backup-project.max_backups');
        $this->maxSize = config('backup-project.max_size');
        $this->backupFrequency = config('backup-project.backup_frequency');
        $this->backupRetention = config('backup-project.backup_retention');
        $this->compression = config('backup-project.compression');
        $this->encryption = config('backup-project.encryption');
        $this->encryptionKey = config('backup-project.encryption_key');
        $this->encryptionCipher = config('backup-project.encryption_cipher');
        $this->notificationEmail = config('backup-project.notification_email');
    }

    // Define methods for backup, restore, and other functionalities here
    public function backup()
    {


        // You can also implement compression and encryption here

        // Example: $this->encrypt($filename);
        // After backup, you can send a notification
        // Example: $this->sendNotification('Backup completed successfully.');
        // You can also log the backup process
        // Example: $this->log('Backup completed successfully.');
        try {
            // Check if the backup path exists, create it if not
            if (!is_dir($this->backupPath)) {
                mkdir($this->backupPath, 0755, true);
            }

            // Define the backup file name and path
            $timestamp = date('Y-m-d_H-i-s');
            $backupFileName = "{$this->name}_backup_{$timestamp}.zip";
            $backupFilePath = $this->backupPath . DIRECTORY_SEPARATOR . $backupFileName;

            // Create a ZIP archive of the source directory
            $sourceDirectory = '/path/to/source/directory'; // Substitute with the actual source directory
            $zip = new \ZipArchive();
            if ($zip->open($backupFilePath, \ZipArchive::CREATE) === true) {
                $this->addFolderToZip($sourceDirectory, $zip);
                $zip->close();
            } else {
                throw new \Exception("Impossibile creare l'archivio ZIP.");
            }

            // Cypher the backup file if encryption is enabled
            if ($this->encryption) {
                $encryptedFilePath = $backupFilePath . '.enc';
                $this->encryptFile($backupFilePath, $encryptedFilePath);
                unlink($backupFilePath); // remove the original file
                $backupFilePath = $encryptedFilePath;
            }

            // send notification
            $this->sendNotification("Backup completato con successo: {$backupFileName}");

            // registra il backup
            $this->log("Backup completato con successo: {$backupFileName}");
        } catch (\Exception $e) {
            // get error message
            $this->log("Errore durante il backup: " . $e->getMessage());
            throw $e;
        }
    }
    public function restore()
    {
        // Implement the restore logic here
    }
    public function deleteOldBackups()
    {
        // Implement the logic to delete old backups here
    }
    public function sendNotification($message)
    {
        // Implement the logic to send notifications here
        // You can use Laravel's Mail facade or any other notification system
    }
    public function log($message)
    {
        // Implement the logic to log messages here
        // You can use Laravel's Log facade or any other logging system
    }
    public function getBackupPath()
    {
        return $this->backupPath;
    }



    private function addFolderToZip($folder, \ZipArchive $zip, $parentFolder = '')
    {
        $folder = rtrim($folder, DIRECTORY_SEPARATOR);
        $folderName = $parentFolder . basename($folder) . '/';

        $zip->addEmptyDir($folderName);

        foreach (scandir($folder) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $folder . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $this->addFolderToZip($filePath, $zip, $folderName);
            } else {
                $zip->addFile($filePath, $folderName . $file);
            }
        }
    }

    private function encryptFile($inputFile, $outputFile)
    {
        $key = $this->encryptionKey;
        $cipher = $this->encryptionCipher;

        $iv = random_bytes(openssl_cipher_iv_length($cipher));
        $inputData = file_get_contents($inputFile);
        $encryptedData = openssl_encrypt($inputData, $cipher, $key, 0, $iv);

        if ($encryptedData === false) {
            throw new \Exception("Errore durante la cifratura del file.");
        }

        file_put_contents($outputFile, $iv . $encryptedData);
    }
}
