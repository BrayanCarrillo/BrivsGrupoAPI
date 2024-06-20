<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function createBackup()
    {
        // Obtener la carpeta de Descargas del usuario
        $userDownloads = 'C:\\Users\\' . get_current_user() . '\\Downloads';
        $filename = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $userDownloads . '\\' . $filename;

        // Obtener las variables de entorno
        $dbName = env('DB_DATABASE', 'fosdb');
        $dbUser = env('DB_USERNAME', 'hola'); // 'hola' como valor por defecto
        $dbPassword = env('DB_PASSWORD', '1234'); // '1234' como valor por defecto
        $dbHost = env('DB_HOST', '127.0.0.1'); // Valor por defecto '127.0.0.1' si no está configurado

        // Variables de respaldo
        $dbDefaultUser = env('DB_DEFAULT_USERNAME', 'root');
        $dbDefaultPassword = env('DB_DEFAULT_PASSWORD', '');

        // Registrar las variables de entorno obtenidas para depuración
        Log::info('DB_DATABASE: ' . $dbName);
        Log::info('DB_USERNAME: ' . $dbUser);
        Log::info('DB_PASSWORD: ' . $dbPassword);
        Log::info('DB_HOST: ' . $dbHost);

        // Verificar si las variables de entorno están configuradas
        if (is_null($dbName) || is_null($dbHost)) {
            Log::error('Las variables de entorno de la base de datos no están configuradas correctamente.');
            return response()->json(['message' => 'Las variables de entorno de la base de datos no están configuradas correctamente.'], 500);
        }

        try {
            // Verificar conexión a la base de datos con las credenciales principales
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                // Si la conexión falla, intenta con las credenciales de respaldo
                $dbUser = $dbDefaultUser;
                $dbPassword = $dbDefaultPassword;
                Log::warning('Conexión fallida con usuario principal, intentando con usuario predeterminado.');

                config(['database.connections.mysql.username' => $dbUser]);
                config(['database.connections.mysql.password' => $dbPassword]);

                DB::purge('mysql');
                DB::reconnect('mysql');
                DB::connection()->getPdo(); // Intentar la conexión nuevamente
            }

            // Añadir PATH de mysqldump si es necesario
            putenv('PATH=' . getenv('PATH') . ';C:\\xampp\\mysql\\bin');

            MySql::create()
                ->setDbName($dbName)
                ->setUserName($dbUser)
                ->setPassword($dbPassword)
                ->setHost($dbHost)
                ->setDumpBinaryPath('C:\\xampp\\mysql\\bin')
                ->dumpToFile($filepath);

            // Verifica si el archivo fue creado exitosamente
            if (file_exists($filepath)) {
                return response()->download($filepath)->deleteFileAfterSend(true);
            } else {
                throw new \Exception('El archivo de backup no fue creado.');
            }
        } catch (\Exception $e) {
            Log::error('Fallo en la creación del backup: ' . $e->getMessage());
            return response()->json(['message' => 'Fallo en la creación del backup', 'error' => $e->getMessage()], 500);
        }
    }


    public function restoreBackup(Request $request)
    {
        Log::info('Inicio del proceso de restauración.');

        // Validar la solicitud
        $validated = $request->validate([
            'backupFile' => 'required|file|mimes:sql',
        ]);

        Log::info('Validación pasada.');

        // Guardar el archivo subido en el almacenamiento
        $file = $request->file('backupFile');
        if (!$file) {
            Log::error('No se encontró el archivo en la solicitud.');
            return response()->json(['message' => 'No se encontró el archivo en la solicitud.'], 422);
        }

        Log::info('Archivo recibido: ' . $file->getClientOriginalName());

        // Guardar el archivo en el almacenamiento
        try {
            $path = $file->storeAs('backups', $file->getClientOriginalName());
        } catch (\Exception $e) {
            Log::error('Error al guardar el archivo: ' . $e->getMessage());
            return response()->json(['message' => 'Error al guardar el archivo.', 'error' => $e->getMessage()], 500);
        }

        Log::info('Archivo guardado en: ' . storage_path('app/' . $path));

        // Comando para restaurar la base de datos
        $command = "mysql --user=hola --password=1234 fosdb < " . storage_path('app/' . $path);
        Log::info('Ejecutando comando: ' . $command);

        $process = Process::fromShellCommandline($command);
        $process->run();

        // Verificar si el comando se ejecutó correctamente
        if (!$process->isSuccessful()) {
            Log::error('Error en el proceso de restauración: ' . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        Log::info('Base de datos restaurada exitosamente.');
        return response()->json(['message' => 'Database restored successfully'], 200);
    }
}