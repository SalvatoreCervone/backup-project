<?php

namespace SalvatoreCervone\BackupProject\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SalvatoreCervone\BackupProject\BackupProject
 */
class BackupProject extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SalvatoreCervone\BackupProject\BackupProject::class;
    }
}
