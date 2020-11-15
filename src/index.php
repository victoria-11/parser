<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/parser/autoload.php');
require_once(__DIR__ . '/scripts/autoload.php');

use Medoo\Medoo;
use Scripts\CsvParsing;

function init() {
    $filePath = __DIR__ . '/test1.csv';

    $db = initDB();

    $db->insert('users', [
        'full_name' => 'full_name',
        'phone' => 'phone',
        'category_id' => '1',
        'days' => 'пн',
        'date_of_birth' => '01.01.1950',
    ]);
    print_r($db->error());
    die;

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
