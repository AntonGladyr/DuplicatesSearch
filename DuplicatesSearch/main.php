#!/usr/bin/php
<?php
include "Client/Client.php";

$client = new Client($argv[1]);
$client->startSearch();

?>