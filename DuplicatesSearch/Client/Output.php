<?php
class Output
{
	function showDuplicates($results)
	{
		foreach ($results as $group => $groups) {
			foreach ($groups as $file) {
				echo "\t$file\n";
			}
			echo str_repeat("-", 100) . "\n";
		}
	}


	function showAmountOfGroups($amount)
	{
		echo "\nGroups: $amount\n";
	}


	function showTime($time)
	{
		echo "Time: $time\n";
	}


	function showError()
	{
		echo "Incorrect path. Try again...\n";
	}
}
?>