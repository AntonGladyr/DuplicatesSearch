#!/usr/bin/php
<?php

require 'vendor/autoload.php';

$controller = new Controller($argv[1]);

$controller->Start();

?>