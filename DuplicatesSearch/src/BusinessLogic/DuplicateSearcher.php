<?php

namespace DuplicatesSearch\BusinessLogic;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DuplicateSearcher
{
	private $myDictionary = array();

	private $linksDictionary = array();

	private $comparator;

	private $counter;

	private $client;


	function __construct()
	{
		$this->comparator = new Comparator();
	}

	function searchDuplicates($path)
	{
		if (!is_null($this->client))
			$this->comparator->attach($this->client);

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
		// Without dots 
		// . - current folder
		// .. - previous folder

		foreach ($iterator as $file) {

			if (is_link($file))
				array_push($this->linksDictionary, $file);
			else {
				if (in_array(filesize($file), array_keys($this->myDictionary))) { // Check file size in dict keys
					$added = false;    // flag
					foreach ($this->myDictionary[filesize($file)] as $index => $group) { // Iterate groups with index
						if ($this->comparator->compare($file, $group[0])) { // Compare first file of group and current file
							$added = true;    // flag = true if added in group
							array_push($this->myDictionary[filesize($file)][$index], $file);
							break;
						}
					}
					if (!$added) {    // If not added, add new group
						array_push($this->myDictionary[filesize($file)], [$file]);
					}
				} else { // If file size not in dict keys
					$this->myDictionary[filesize($file)] = [[$file]]; // Add new file size => groups
				}
			}
		}
	}

	function getFilteredResult()
	{
		$result = array();
		foreach ($this->myDictionary as $size => $groups) {
			foreach ($groups as $group) {
				if (count($group) > 1) {
					$this->counter++;
					array_push($result, $group);
				}
			}
		}
		return $result;
	}

	function getAmountOfGroups()
	{
		return $this->counter;
	}

	function getUnfilteredResult()
	{
		return $this->myDictionary;
	}

	function getLinks()
	{
		return $this->linksDictionary;
	}


	function setClient($client)
	{
		$this->client = $client;
	}
}
?>