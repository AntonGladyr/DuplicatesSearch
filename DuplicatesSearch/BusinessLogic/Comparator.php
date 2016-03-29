<?php

class Comparator implements \SplSubject
{
	const BUFFER = 32767;  //4096 - cluster

	private $observers = array();

	private $statusBar;

	function __construct()
	{
		$this->processing = new Processing();
	}


	public function compare($path1, $path2)  // Compare file by bytes
	{
			$totalSize = 0;

			$file1 = fopen($path1, 'rb');
			$file2 = fopen($path2, 'rb');
			
			while (($f1_bytes = fread($file1, self::BUFFER)) != false)
			{
				$f2_bytes = fread($file2, self::BUFFER);
				$this->statusBar = $this->processing->show_status($totalSize += self::BUFFER, filesize($path1));
				$this->notify();

				if ($f1_bytes !== $f2_bytes)
				{
					$this->statusBar = $this->processing->show_status(filesize($path1), filesize($path1));
					$this->notify();
					fclose($file1);
					fclose($file2);
					return false;
				}
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

	public function setObservers($observers)
	{
		$this->observers = $observers;
	}

	//notify observers(or some of them)
	public function notify() {
		foreach ($this->observers as $value) {
			$value->update($this);
		}
	}

	public function getStatusBar() {
		return $this->statusBar;
	}

}
?>