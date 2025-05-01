<?php

namespace SalvatoreCervone\BackupProject;

class BackupProject
{
    // Define the properties and methods for the BackupProject class here
    protected $listpathbackup;


    public function __construct()
    {
        // Initialize properties with default values or from configuration
        $this->listpathbackup = config('backup-project.listpathbackup');
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
            foreach ($this->listpathbackup as  $config) {


                $name = $config['name'];
                $sorcePath = $config['sorce_path'];
                $backupPath = $config['backup_path'];
                $logPath = $config['log_path'];
                $maxBackups = $config['max_backups'];
                $maxSize = $config['max_size'];
                $backupFrequency = $config['backup_frequency'];
                $backupRetention = $config['backup_retention'];
                $compression = $config['compression'];
                $encryption = $config['encryption'];
                $encryptionKey = $config['encryption_key'];
                $encryptionCipher = $config['encryption_cipher'];
                $notificationEmail = $config['notification_email'];
            }
            // Check if the backup path exists, create it if not
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            // Define the backup file name and path
            $timestamp = date('Y-m-d_H-i-s');
            $backupFileName = "{$name}_backup_{$timestamp}.zip";
            $backupFilePath = $backupPath . DIRECTORY_SEPARATOR . $backupFileName;

            // Create a ZIP archive of the source directory
            $sourceDirectory = $sorcePath; // Substitute with the actual source directory
            $zip = new \ZipArchive();
            if ($zip->open($backupFilePath, \ZipArchive::CREATE) === true) {
                $resultAddZip = $this->addFolderToZip($sourceDirectory, $zip);
                $this->errorAddFolderToZip($resultAddZip);
                $zip->close();
            } else {
                throw new \Exception("impossible to create zip file");
            }

            // Cypher the backup file if encryption is enabled
            if ($encryption) {
                $encryptedFilePath = $backupFilePath . '.enc';
                $this->encryptFile($backupFilePath, $encryptedFilePath, $encryptionKey, $encryptionCipher);
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




    private function addFolderToZip($folder, \ZipArchive $zip, $parentFolder = '')
    {
        $folder = rtrim($folder, DIRECTORY_SEPARATOR);
        $folderName = $parentFolder . basename($folder) . '/';

        $zip->addEmptyDir($folderName);
        if (!is_dir($folder)) {
            return ['status' => false, 'message' => 'directory not exists'];
        }
        foreach (scandir($folder) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $folder . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                $resultAddZip = $this->addFolderToZip($filePath, $zip, $folderName);
                $this->errorAddFolderToZip($resultAddZip);
            } else {
                $zip->addFile($filePath, $folderName . $file);
            }
        }
        return ['status' => true, 'message' => 'directory added'];
    }

    private function encryptFile($inputFile, $outputFile, $encryptionKey, $encryptionCipher)
    {
        $key = $encryptionKey;
        $cipher = $encryptionCipher;

        $iv = random_bytes(openssl_cipher_iv_length($cipher));
        $inputData = file_get_contents($inputFile);
        $encryptedData = openssl_encrypt($inputData, $cipher, $key, 0, $iv);

        if ($encryptedData === false) {
            throw new \Exception("Errore durante la cifratura del file.");
        }

        file_put_contents($outputFile, $iv . $encryptedData);
    }

    private function errorAddFolderToZip($resultAddZip)
    {
        if ($resultAddZip['status'] === false) {
            throw new \Exception($resultAddZip['message']);
        }
    }
}
