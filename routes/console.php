<?php

use App\Jobs\WebParserJob;
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

Artisan::command('cliWebParser {url}', function($url){

    if (file_exists('output.json')) {
        unlink('output.json');
    }

    $domDocument = new DOMDocument();
    @ $domDocument->loadHTMLFile($url);

    dispatch(new WebParserJob($domDocument, 'a','href'));

    dispatch(new WebParserJob($domDocument, 'img','src'));

    dispatch(new WebParserJob($domDocument, 'script','src'));

    dispatch(new WebParserJob($domDocument, 'link','href'));

})->purpose('Find all values of attributes href/src from passed url');
