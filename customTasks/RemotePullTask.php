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
	       if(!$sftp->login($this->remote_username, $this->remote_password)){
	       	throw new BuildException("Could not login to $this->remote_address with username $this->remote_username and $this->remote_password");
	       }

	       if($sftp->put($this->expect_file, $this->expect_file, NET_SFTP_LOCAL_FILE) !== TRUE){
	       	 throw new BuildException("Could not put file onto the server, please try again");				 
		}
		if($sftp->exec("chmod 755 $this->expect_file") !== ""){
		throw new BuildException("Could not make expect file executable");
		}
	       
	       if( $sftp->exec("mv $this->expect_file $this->remote_directory" .$this->expect_file_name ) !== ""){
	       		       throw new BuildException("Unable to move the file to $this->remote_directory\n".
			       	     	 	        "The remote server gave error $move_result");
		}

	       echo $sftp->exec("cd $this->remote_directory;./$this->expect_file");
	       
	       exec("rm $this->expect_file");
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