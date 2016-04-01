<?php

namespace DuplicatesSearch\Client;

class Output
{
	function showDuplicates($results)
	{
		echo "\nDuplicate files:\n";
		foreach ($results as $group => $groups) {
			foreach ($groups as $file) {
				echo "\t$file\n";
			}
			echo str_repeat("-", 100) . "\n\n";
		}
	}

	function showLinks($links)
	{
		echo "Links:\n";
		foreach ($links as $link)
		{
			echo "\t$link\n";
		}
		echo "\n";
	}


	function showAmountOfGroups($amounts)
	{
		echo "Groups: $amounts\n";
	}


	function showTime($time)
	{
		echo "Time: $time\n\n";
	}


	function showError()
	{
		echo "Incorrect path. Try again...\n";
	}


	function showStatusBar($status)
	{
		echo "$status  ";
		flush();
	}

	function showNewLine()
	{
		echo "\n";
	}
}
?>