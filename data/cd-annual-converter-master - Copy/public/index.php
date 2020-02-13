<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('log_errors', true);
error_reporting(E_ALL);
date_default_timezone_set('Europe/Amsterdam');

require './../vendor/autoload.php';

$tmpPath = realpath('./../tmp');
$annualConverter = new \App\AnnualConverter($tmpPath);
$files = scandir('./../storage/annuals/');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file = realpath('./../storage/annuals/' . $file);
        dump($file, $annualConverter->convert($file));
    }
}
