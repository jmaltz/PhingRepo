<?php
	require_once("GitRemoteTask.php");	
	require_once("includeRemoteLib.php");
	require_once("phpseclib/Net/SFTP.php");

	class RemotePullTask extends GitRemoteTask {
	
	protected $command = "git pull";

	protected $remote_address = NULL;
	protected $remote_directory = NULL;

	protected $remote_username = NULL;
	protected $remote_password = NULL;
	
	
	public function init() {}

	public function main() {
	       $expect_file_result = $this->createExpectFile($this->expect_file);
	       
	       if(!$expect_file_result){
		throw new BuildException("Error creating the expect file for remote use");
	       }

	       $sftp = new Net_SFTP($this->remote_address);
	       //sftp it over to the server
	}

	public function setRemote_Address($remote_address){
	       $this->remote_address = $remote_address;
	}

	public function setRemote_Directory($remote_directory){
	       $this->remote_directory = $remote_directory;
	}

	public function setRemote_Username($remote_username){
	       $this->remote_username = $remote_username;
	}
	
	public function setRemote_Password($remote_password){
	       $this->remote_password = $remote_password;
	}

}

?>