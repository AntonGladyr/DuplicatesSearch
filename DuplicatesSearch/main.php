#!/usr/bin/php
<?php

require_once 'vendor/autoload.php';

$controller = new Controller($argv);

$controller->start();

?>