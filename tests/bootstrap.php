<?php

error_reporting(E_ALL);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->addPsr4('Harp\\Range\\Test\\', __DIR__.'/src');
$loader->addPsr4('Harp\\Validate\\Test\\', __DIR__.'/../vendor/harp-orm/validate/tests/src');
