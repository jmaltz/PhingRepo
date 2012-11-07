<?php
	class RemoteTask extends Task {
	      
	      protected $remote = NULL;

	      /*Performs any one-time initalization, doesn't do anything in this case*/
	      public function init() {}

	      public function main(){

	      	     $result = shell_exec("git pull " . $this->remote . " master");
	      	     if(!$result){
				echo "Error, failed git pulling";
		     		return;
		     }
		     echo "Successfully pulled from the git repo\n";
		     $command = "git push -u " . $this->remote;
		     $result = shell_exec($command);

	      	     if(!$result){
			return;
			}
	      }

	      public function setRemote($remote){
	      	     $this->remote = $remote;
		     }

	}	

?>