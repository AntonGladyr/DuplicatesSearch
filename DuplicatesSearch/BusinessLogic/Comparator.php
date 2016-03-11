<?php

class Comparator
{
	public function Compare($path1, $path2)  // Compare file by bytes
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
}
?>