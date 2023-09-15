<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('upload:cleanup', function () {
    $this->info('Cleaning up the tmp uploads folder...');

    $files = Storage::disk('public')->listContents('tmp');

    $numberOfFiles = collect($files)
        ->filter(function($file){
            return $file['type'] === 'file' && $file['lastModified'] < now()->subMinutes(1)->getTimestamp();
        })->each(function($file){
            // dump($file);
            Storage::disk('public')->delete($file['path']);
        })->count();

    $this->info("$numberOfFiles files have been delete on ".now());
})->purpose('Clean up the tmp uploads folder');
