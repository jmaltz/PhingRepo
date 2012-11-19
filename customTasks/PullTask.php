<?php
	include("GitRemoteTask.php");

	class PullTask extends GitRemoteTask {	      
	      protected $command = "git pull origin master";
	}

?>