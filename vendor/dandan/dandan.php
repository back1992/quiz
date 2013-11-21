<?php

// namespace Dandan;

class Dandan {
	public  static	function dirToArray($dir, $path = false) { 
		$result = array(); 
		$cdir = scandir($dir); 
		foreach ($cdir as $key => $value) 
		{ 
			if (!in_array($value,array(".",".."))) 
			{ 
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
				{ 
					$result[$value] = self::dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
				} 
				else 
				{ 
					// (!$path) ? $result[] =  $value : $result[] = $dir . DIRECTORY_SEPARATOR . $value; 
					$result[] =  (!$path) ? $value : $dir . DIRECTORY_SEPARATOR . $value; 
				} 
			} 
		} 
		return $result; 
	}
}