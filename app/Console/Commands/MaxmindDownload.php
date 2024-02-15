<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PharData;
use RecursiveIteratorIterator;

class MaxmindDownload extends Command
{
    protected $signature = 'maxmind:download';

    protected $description = 'Update the MaxMind database.';

    public function handle()
    {
        $mmdbPath = config('location.database');

        if (! file_exists($mmdbPath)) {

            @mkdir(
                $root = Str::beforeLast(
                    $mmdbPath,
                    DIRECTORY_SEPARATOR
                )
            );

            $storage = Storage::build([
                'driver' => 'local',
                'root' => $root,
            ]);

            $url = config('location.download_url');
            $tarFileName = 'maxmind.tar.gz';
            $tarPath = $storage->path($tarFileName);

            if (! file_exists($tarPath)) {
                $this->line('Downloading MaxMind database...');
                $storage->put($tarFileName, file_get_contents($url));
            }

            $this->line('Extracting database...');
            $phar = new PharData($tarPath);

            $iterator = new RecursiveIteratorIterator($phar);
            foreach ($iterator as $file) {
                if ($file->getExtension() === 'mmdb') {
                    $contents = file_get_contents($file->getPathName());
                    file_put_contents($mmdbPath, $contents);
                    break;
                }
            }

            $this->line('Cleaning up...');
            $storage->delete($tarFileName);
        } else {
            $this->info('MaxMind database is already up to date.');
        }
    }
}
