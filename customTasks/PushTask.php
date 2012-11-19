<?php
	require_once("GitRemoteTask.php");

	class PushTask extends GitRemoteTask {	      
	      protected $command = "git push origin master";
	}

?>