<?php

define("BUFFER", 4096); //BUFFER

class Comparator
{
	public function Compare($path1, $path2)  // Compare file by bytes
	{
			$file1 = fopen($path1, 'rb');
			$file2 = fopen($path2, 'rb');
			
			while (($f1_bytes = fread($file1, BUFFER)) != false)
			{
				$f2_bytes = fread($file2, BUFFER);
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
}
?>