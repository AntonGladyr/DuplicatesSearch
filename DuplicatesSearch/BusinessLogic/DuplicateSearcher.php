<?php

class DuplicateSearcher
{
	private $myDictionary = array();

	private $linksDictionary = array();

	private $comparator;

	private $processing;

	private $counter;

	//function __construct() { }

	function __construct()
	{
		$this->comparator = new Comparator();
		$this->processing = new Processing();
	}


	function searchDuplicates($path)
	{
		$totalSize = 0;
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
		// Without dots 
		// . - current folder
		// .. - previous folder

		foreach ($iterator as $file) {

			if (is_link($file))
				array_push($this->linksDictionary, $file);
			else {
				if (in_array(filesize($file), array_keys($this->myDictionary))) { // Check filesize in dict keys
					$added = false;    // flag
					foreach ($this->myDictionary[filesize($file)] as $index => $group) { // Iterate groups with index
						if ($this->comparator->Compare($file, $group[0])) { // Compare first file of group and current file
							$added = true;    // flag = true if added in group
							array_push($this->myDictionary[filesize($file)][$index], $file);
							break;
						}
					}
					if (!$added) {    // If not added, add new group
						array_push($this->myDictionary[filesize($file)], [$file]);
					}
				} else { // If filesize not in dict keys
					$this->myDictionary[filesize($file)] = [[$file]]; // Add new filesize => groups
				}
			}

			$this->processing->show_status($totalSize += filesize($file), disk_total_space($path)/4096);
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
}
?>