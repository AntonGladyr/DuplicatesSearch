#!/usr/bin/php
<?php

use DuplicatesSearch\Controller\Controller;

require_once 'vendor/autoload.php';

$controller = new Controller($argv);

$controller->start();

?>