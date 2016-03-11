#!/usr/bin/php
<?php

include "Client/Client.php";
include "Client/Input.php";
include "Client/Validator/Validator.php";

$Validator = new Validator();

$Client = new Client();

$Input = new Input();

$Output = new Output();

$StartFlag = true;

if (empty($argv[1]))
    $Input->setPath("./");
else
    if ($Validator->isValidate($argv[1]))
        $Input->setPath($argv[1]);  //path to directory
else
{
    $Output->showError();
    $StartFlag = false;
}

if ($StartFlag)
{
    $Client->Start($Input->getPath());
}

?>