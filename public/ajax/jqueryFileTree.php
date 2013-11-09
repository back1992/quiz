<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//
ini_set('display_errors', '1');
$root = '../';

$_POST['dir'] = urldecode($_POST['dir']);
// $_POST['dir'] = '../';
$scanDir = $root.$_POST['dir'];
if( file_exists($root . $_POST['dir']) ) {
	$files = scandir($scanDir);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		// var_dump($files);
		echo "<ul class=\"jqueryFileTree\" style=\"display:true;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($scanDir . $file) && $file != '.' && $file != '..' && is_dir($scanDir . $file) ) {
				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
			}
		}
		// All files
		foreach( $files as $file ) {
			if( file_exists($scanDir . $file) && $file != '.' && $file != '..' && !is_dir($scanDir . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		}
		echo "</ul>";	
	}
}

?>