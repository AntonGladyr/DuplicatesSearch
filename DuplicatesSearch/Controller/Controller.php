<?php

class Controller
{
    private $duplicateSearcher;

    private $client;


    function __construct($argv)
    {
        $this->client = new Client($argv);
        $this->duplicateSearcher = new DuplicateSearcher();
    }

    public function start()
    {
        $start_time = microtime($get_as_float=true);

        $path = $this->client->getPath();

        if (!is_null($path))
        {
            $this->duplicateSearcher->setClient($this->client);

            $this->duplicateSearcher->searchDuplicates($path);

            $this->client->displayFilteredResult($this->duplicateSearcher->getFilteredResult());

            $this->client->displayLinks($this->duplicateSearcher->getLinks());

            $this->client->displayAmountOfGroups($this->duplicateSearcher->getAmountOfGroups());

            $time = microtime($get_as_float=true) - $start_time;

            $this->client->displayTime($time);
        }
    }
}

?>