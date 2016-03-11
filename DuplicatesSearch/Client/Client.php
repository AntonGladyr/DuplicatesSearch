<?php
include "BusinessLogic/DuplicateSearcher.php";
include "Output.php";


class Client
{

	private $Output;

	function __construct()
	{
		$this->Output = new Output();
	}

	function Start($path)
	{
			$start_time = microtime($get_as_float=true);

			$duplicateSearcher = new DuplicateSearcher($path);

			$duplicateSearcher->searchDuplicates();

			$this->Output->showDuplicates($duplicateSearcher->getFilteredResult());

			$this->Output->showAmountOfGroups($duplicateSearcher->getAmountOfGroups());

			$time = microtime($get_as_float=true) - $start_time;

			$this->Output->showTime($time);
	}
}

?>