<?php
	require_once("GitRemoteTask.php");	

	class RemotePullTask extends GitRemoteTask {
	
	protected $command = "git pull";
	
	public function init() {}

	public function main() {
	       $expect_file_result = $this->createExpectFile($this->expect_file);
	       
	       if(!$expect_file_result){
		throw new BuildException("Error creating the expect file for remote use");
	       }

	       //sftp it over to the server
	}

	public function setRemoteAddr(){

	}
}

?>