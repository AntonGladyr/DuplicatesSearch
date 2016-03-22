<?php
include "BusinessLogic/DuplicateSearcher.php";
include "Output.php";
include "Client/Input.php";
include "Client/Validator/Validator.php";


class Client
{
	private $output;
	private $input;
	private $validator;

	function __construct($path)
	{
		$this->output = new Output();
		$this->validator = new Validator();
		$this->input = new Input();
		$this->input->setPath($path);
	}

	function startSearch()
	{
			if ($this->validator->isValidate($this->input->getPath()))
			{
				$start_time = microtime($get_as_float=true);

				$duplicateSearcher = new DuplicateSearcher($this->input->getPath());

				$duplicateSearcher->searchDuplicates();

				$this->output->showDuplicates($duplicateSearcher->getFilteredResult());

				$this->output->showLinks($duplicateSearcher->getLinks());

				$this->output->showAmountOfGroups($duplicateSearcher->getAmountOfGroups());

				$time = microtime($get_as_float=true) - $start_time;

				$this->output->showTime($time);
			}
			else
				$this->output->showError();
	}
}

?>