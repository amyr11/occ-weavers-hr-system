<?php

namespace App\Actions;

use App\Models\Backup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BackupDatabase
{
    public function __invoke()
    {
        [
            'host' => $host,
            'port' => $port,
            'database' => $database,
            'username' => $username,
            'password' => $password
        ] = config('database.connections.mysql');

        $filename = $database . '_backup_' . Str::random(8) . '.sql.gz';
        $path = storage_path("app/backups/{$filename}");

        $command = "mysqldump --host={$host} --port={$port} --user={$username} --password={$password} --single-transaction --quick --lock-tables=false {$database} | gzip > {$path}";

        Backup::create([
            'filename' => $filename,
            'user_id' => Auth::id(),
        ]);

        exec($command, $output, $resultCode);

        if ($resultCode) {
            logger('Backup failed: ' . implode("\n", $output));
        }

        return $filename;
    }
}
