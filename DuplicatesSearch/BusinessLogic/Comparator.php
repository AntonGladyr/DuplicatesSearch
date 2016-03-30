<?php

class Comparator implements \SplSubject
{
	const BUFFER = 32767;  //4096 - cluster

	private $observers = array();

	private $done;

	private $total;

	public function compare($path1, $path2)  // Compare file by bytes
	{
			$this->total = 0;
			$this->done = 0;

			$file1 = fopen($path1, 'rb');
			$file2 = fopen($path2, 'rb');
			
			while (($f1_bytes = fread($file1, self::BUFFER)) != false)
			{
				$f2_bytes = fread($file2, self::BUFFER);

				if ($f1_bytes !== $f2_bytes)
				{
					$this->total = filesize($path1);
					$this->done = filesize($path1);
					$this->notify();
					fclose($file1);
					fclose($file2);
					return false;
				}

				$this->done += self::BUFFER;
				$this->total = filesize($path1);
				$this->notify();
			}
			
			fclose($file1);
			fclose($file2);
			return true;
	}

	//add observer
	public function attach(\SplObserver $observer) {
		$this->observers[] = $observer;
	}

	//remove observer
	public function detach(\SplObserver $observer) {

		$key = array_search($observer,$this->observers, true);
		if($key){
			unset($this->observers[$key]);
		}
	}

	//notify observers(or some of them)
	public function notify() {
		foreach ($this->observers as $value) {
			$value->update($this);
		}
	}

	public function getDoneBytes()
	{
		return $this->done;
	}

	public function getTotalBytes()
	{
		return $this->total;
	}
}
?>