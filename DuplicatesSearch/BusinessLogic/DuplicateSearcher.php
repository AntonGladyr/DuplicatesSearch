<?php
include "Comparator.php";

class DuplicateSearcher
{
	private $MyDictionary = array();

	private $FolderPath; 

	private $Comparator;

	private $counter;

	//function __construct() { }

	function __construct($path)
	{
		$this->FolderPath = $path;
		$this->Comparator = new Comparator();
	}


	function searchDuplicates()
	{
		$Iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($this->FolderPath, RecursiveDirectoryIterator::SKIP_DOTS));
		// Without dots 
		// . - current folder
		// .. - previous folder

		foreach ($Iterator as $file)
		{		
			if (in_array(filesize($file), array_keys($this->MyDictionary))) { // Check filesize in dict keys
				$added = false;	// flag
				foreach ($this->MyDictionary[filesize($file)] as $index => $group) { // Iterate groups with index
					if ($this->Comparator->Compare($file, $group[0])) { // Compare first file of group and current file
						$added = true;	// flag = true if added in group
						array_push($this->MyDictionary[filesize($file)][$index], $file);
						break;
					}
				}
				if (!$added) {	// If not added, add new group
					array_push($this->MyDictionary[filesize($file)], [$file]);
				}
			}
			else { // If filesize not in dict keys
				$this->MyDictionary[filesize($file)] = [[$file]]; // Add new filesize => groups
			}
		}
	}

	function getFilteredResult()
	{
		$result = array();
		foreach ($this->MyDictionary as $size => $groups) {
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
		return $this->MyDictionary;
	}
}
?>