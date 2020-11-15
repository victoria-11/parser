<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/parser/autoload.php');
require_once(__DIR__ . '/scripts/autoload.php');

use Medoo\Medoo;
use Scripts\CsvParsing;

function init() {
    $filePath = __DIR__ . '/test.csv';

    $db = initDB();

    $script = new CsvParsing($filePath, $db);

    $script->run();
}

function initDB(): Medoo {
    return new Medoo([
        'database_type' => 'pgsql',
        'database_name' => 'parser',
        'server' => 'db',
        'username' => 'dev',
        'password' => 'secret'
    ]);
}

init();
