<?php

namespace Ffmpeg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ffmpeg\Form\DirForm;
use Zend\Stdlib\Hydrator;

class FfmpegController extends AbstractActionController
{

	public function indexAction()
	{
		$form = new DirForm();
		$data = array(
			'title'    => './public/audio',
			);
		$form->setData($data);
		return array(
			'form' => $form,
			);
	}
	public function scanAction()
	{
		$dir = './public/';
		$form = new DirForm();

		if( file_exists($dir) ) {
			$files = $this->dirToArray($dir);
			krsort($files);
		}
		return array('files' => $files, 'dir' => $dir, 'form' => $form);
	} 
	public function convertAction()
	{
		// system('shell_exec('ffmpeg -i ./data/mp3/'. $audiofile . ' '.$path_parts['filename'].'.ogg');');
		$request = $this->getRequest();
		if ($request->isPost()) {
			$sDir=$request->getPost()->title;
			$sFiles = $this->dirToArray($sDir);


			var_dump($sDir);
			var_dump($sFiles);
			$cmd_rm = 'rm ' . $sDir . '/*.ogg';
			shell_exec($cmd_rm);
			foreach ($sFiles as $sFile) {
				$sFile_parts = pathinfo($sFile);
				if ($sFile_parts['extension'] == 'mp3')
				{
					$sourceFile = $sDir . '/'.$sFile;
					$targetFile =  str_replace('.mp3', '.ogg', $sourceFile);
					
					$cmd_conv = 'ffmpeg -i '. $sourceFile .'  -acodec libvorbis  '. $targetFile;
					// var_dump($command);


					shell_exec($cmd_conv);
				// shell_exec('ffmpeg -i '. $sDir . '/'.$sFile .' '. $sDir. '/ogg/'.$sFile_parts['basename'].'.ogg' );
				}
			}

		}

		return false;

	}
	
	function dirToArray($dir) { 

		$result = array(); 

		$cdir = scandir($dir); 
		foreach ($cdir as $key => $value) 
		{ 
			if (!in_array($value,array(".",".."))) 
			{ 
				if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
				{ 
					$result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
				} 
				else 
				{ 
					$result[] = $value; 
				} 
			} 
		} 

		return $result; 
	}


	function php_file_tree_dir($directory, $return_link, $extensions = array(), $first_call = true) 
	{
		$php_file_tree = '';
	// Recursive function called by php_file_tree() to list directories/files

	// Get and sort directories/files
		$file = scandir($directory); 
		natcasesort($file);
	// Make directories first
		$files = $dirs = array();
		foreach($file as $this_file) {
			if( is_dir("$directory/$this_file" ) ) $dirs[] = $this_file; else $files[] = $this_file;
		}
		$file = array_merge($dirs, $files);

		var_dump($file);

		if( count($file) > 2 ) { 
	// Use 2 instead of 0 to account for . and .. "directories"
			$php_file_tree = "<ul";
			if( $first_call ) { 
				$php_file_tree .= " class=\"php-file-tree\""; 
				$first_call = false; 
			}
			$php_file_tree .= ">";
			foreach( $file as $this_file ) {
				if( $this_file != "." && $this_file != ".." ) {
					if( is_dir("$directory/$this_file") ) {
					// Directory
						$php_file_tree .= "<li class=\"pft-directory\"><a href=\"#\">" . htmlspecialchars($this_file) . "</a>";
						$php_file_tree .= $this->php_file_tree_dir("$directory/$this_file", $return_link ,$extensions, false);
						$php_file_tree .= "</li>";
					} else {
					// File
					// Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
						$ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1); 
						$link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);
						$php_file_tree .= "<li class=\"pft-file " . strtolower($ext) . "\"><a href=\"$link\">" . htmlspecialchars($this_file) . "</a></li>";
					}
				}
			}
			$php_file_tree .= "</ul>";
		}
		return $php_file_tree;
	}

}

