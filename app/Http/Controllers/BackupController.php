<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Http\Response;

class BackupController extends Controller
{

    function backupDatabase()
    {
        // Obtener la configuración de la base de datos desde las variables de entorno
        $dbHost = env('DB_HOST');
        $dbDatabase = env('DB_DATABASE');
        $dbUsername = env('DB_USERNAME');
        $dbPassword = env('DB_PASSWORD');

        // Nombre y ruta del archivo SQL de respaldo
        $fileName = 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $sqlFilePath = storage_path($fileName);

        // Ejecutar el comando mysqldump para realizar el respaldo
        $command = sprintf('mysqldump --user=%s --password=%s --host=%s %s > %s', $dbUsername, $dbPassword, $dbHost, $dbDatabase, $sqlFilePath);
        exec($command);

        // Guardar el archivo SQL en la raíz del proyecto
        $sqlFile = base_path($fileName);
        File::copy($sqlFilePath, $sqlFile);

        return $sqlFile;
    }

    public function allBackup()
    {
        set_time_limit(300);

        // 1. Realizar un respaldo SQL de toda la base de datos
        $sqlFilePath = $this->backupDatabase();

        // 3. Crear un archivo ZIP de toda la carpeta raíz del proyecto
        $zipFilePath = $this->createRootFolderZip();

        // 4. Descargar el archivo ZIP con nombre basado en la fecha actual
        if (file_exists($zipFilePath)) {
            // return response()->download($zipFilePath)->header('Content-Type', 'application/zip');
            // dd($zipFilePath);
            $name= 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.zip';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$name");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // Read the file
            readfile($zipFilePath);

            $this->deleteBackupFiles();
        }

    }


    public function dbBackup(){
        $sqlFilePath = $this->backupDatabase();

        $name= 'backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$name");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // Read the file
            readfile($zipFilePath);

            $this->deleteBackupFiles();
    }


    function createRootFolderZip()
    {
        // Ruta y nombre del archivo ZIP
        $zipFilePath = base_path('NES-backup_' . Carbon::now()->format('Y-m-d_H-i-s') . '.zip');

        // Ruta de la carpeta raíz del proyecto
        $rootPath = base_path();

        // Obtener todos los archivos de la carpeta raíz
        $files = File::allFiles($rootPath);

        // Crear el archivo ZIP
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Agregar los archivos a la carpeta raíz del archivo ZIP
        foreach ($files as $file) {
            $relativePath = 'backup/' . $file->getRelativePathname();
            $zip->addFile($file->getRealPath(), $relativePath);
        }

        $zip->close();

        return $zipFilePath;
    }

    function deleteBackupFiles()
    {
        $backupFiles = array_merge(File::glob(base_path('*.zip')), File::glob(base_path('*.sql')), File::glob(storage_path('*.sql')));

        foreach ($backupFiles as $file) {
            File::delete($file);
        }

        return true;
    }

}
