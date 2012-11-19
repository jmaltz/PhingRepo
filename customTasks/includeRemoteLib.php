<?php
	$cwd = getcwd() . DIRECTORY_SEPARATOR;
	$result = set_include_path(get_include_path() . PATH_SEPARATOR . "$cwd" . "phpseclib");
	if($result === FALSE){
		   throw new BuildException("Error, couldn't include the remote connection library");
	}

	include("Net/SSH2.php");
?>