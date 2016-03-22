<?php
include "../BusinessLogic/DuplicateSearcher.php";
include  "../Client/Client.php";

class Controller
{
    private $duplicateSearcher;

    private $client;

    function __construct($path)
    {
        $this->client = new Client($path);
        $this->duplicateSearcher = new DuplicateSearcher($path);
        $this->delegate();
    }

    private function delegate()
    {
        $this->duplicateSearcher->searchDuplicates();
    }
}

?>