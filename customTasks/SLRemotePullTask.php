<?php
	require_once("SLGitBaseTask.php");	
	require_once("Net/SFTP.php");
	class SLRemotePullTask extends SLGitBaseTask {
	
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
	       if(!$sftp->login($this->remote_username, $this->remote_password)){ //login
	       	throw new BuildException("Could not login to $this->remote_address with username $this->remote_username and $this->remote_password");
	       }

	       if($sftp->put($this->expect_file, $this->expect_file, NET_SFTP_LOCAL_FILE) !== TRUE){ //put the expect file onto the remote server
	       	 throw new BuildException("Could not put file onto the server, please try again");				 
		}
		if($sftp->exec("chmod 755 $this->expect_file") !== ""){ //modify the file to be executable
		throw new BuildException("Could not make expect file executable");
		}
	       
	       if( $sftp->exec("mv $this->expect_file $this->remote_directory/" . $this->expect_file ) !== ""){ //move the expect file to its directory
	       		       throw new BuildException("Unable to move the file to $this->remote_directory\n".
			       	     	 	        "The remote server gave error $move_result");
		}

	       	$expect_result = $sftp->exec("cd $this->remote_directory;./$this->expect_file");
		$sftp->exec("cd $this->remote_directory;rm $this->expect_file");  //remove the leftover expect file
		$this->log($expect_result, Project::MSG_VERBOSE);

		if(strpos($expect_result, "Aborting") || strpos($expect_result, "CONFLICT")){ //if there was an error
			throw new BuildException("Error pulling from git on the remote machine.  We reverted, please resolve the merge manually");
		}
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
