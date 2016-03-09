#!/usr/bin/php
<?php

	function compare($path1, $path2)  // Compare file by bytes
	{
			$file1 = fopen($path1, 'rb');
			$file2 = fopen($path2, 'rb');
			
			while (($f1_bytes = fread($file1, 4096)) != false)
			{
				$f2_bytes = fread($file2, 4096);
				if ($f1_bytes !== $f2_bytes)
				{
					fclose($file1);
					fclose($file2);
					return false;
				}
			}
			
			fclose($file1);
			fclose($file2);
			return true;
	}


	$start_time = microtime($get_as_float=true);
	$path = $argv[1];  //path to directory

	$Iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
	// Without dots 
		// . - current folder
		// .. - previous folder




	$MyDictionary = array();

	foreach ($Iterator as $file)
	{		
		if (in_array(filesize($file), array_keys($MyDictionary))) { // Check filesize in dict keys
			$added = false;	// flag
			foreach ($MyDictionary[filesize($file)] as $index => $group) { // Iterate groups with index
				if (compare($file, $group[0])) { // Compare first file of group and current file
					$added = true;	// flag = true if added in group
					array_push($MyDictionary[filesize($file)][$index], $file);
					break;
				}
			}
			if (!$added) {	// If not added, add new group
				array_push($MyDictionary[filesize($file)], [$file]);  
			}
		}
		else { // If filesize not in dict keys
			$MyDictionary[filesize($file)] = [[$file]]; // Add new filesize => groups
		}
	}


	$count = 0;
	foreach ($MyDictionary as $size => $groups) {
		foreach ($groups as $group) {
			if (count($group) > 1) {
				$count++;
				echo "File size: $size \n";
				foreach ($group as $file) {
					echo "\t$file\n";
				} 
				echo "\n";
			}
		}
	}

	$time = microtime($get_as_float=true) - $start_time;

	echo "Time: $time\n";
	echo "Groups: $count\n";

	//print_r($MyDictionary);
	
?>