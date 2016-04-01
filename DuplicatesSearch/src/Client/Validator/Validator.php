<?php

namespace DuplicatesSearch\Client\Validator;

class Validator
{
    // Check path
    function isValidate($path)
    {
        if(file_exists($path) && is_dir($path))
            return true;
        else
            return false;
    }
}

?>