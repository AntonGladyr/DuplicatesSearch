<?php

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

	function  getPath()
	{
		if ($this->validator->isValidate($this->input->getPath()))
			return $this->input->getPath();
		else
		{
			$this->output->showError();
			return null;
		}
	}

	function displayFilteredResult($results)
	{
		$this->output->showDuplicates($results);
	}

	function  displayLinks($links)
	{
		$this->output->showLinks($links);
	}

	function displayAmountOfGroups($amounts)
	{
		$this->output->showAmountOfGroups($amounts);
	}

	function displayTime($time)
	{
		$this->output->showTime($time);
	}
}

?>