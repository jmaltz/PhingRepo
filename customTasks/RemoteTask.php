<?php
	
	class RemoteTask extends Task {
	      
	      protected $remote = NULL;
	      protected $password = NULL;
	      protected $branch = NULL;
	      protected $passwordPrompt = NULL;

	      /*Performs any one-time initalization, doesn't do anything in this case*/
	      public function init() {}

	      public function main(){
	      	     var_dump(get_magic_quotes_gpc());
	      	     $fh = fopen ("expectcmd", "w+");
		     fwrite($fh, "#!/usr/bin/expect -f\n");
		     fwrite($fh, "spawn git pull origin master\n");
		     fwrite($fh, "expect {\n");
		     
		     $this->password = str_replace("\"", "", $this->password);
		     $password_string = $this->password . "\\r";
		     fwrite($fh, " $this->passwordPrompt   {send  \"$password_string\" }\n");
		     fwrite($fh, "\"Already up-to-date\" {exit 0}\n");
		     fwrite($fh, "default          {exit 1}\n");
		     fwrite($fh, "}\n");
		     fclose($fh);
		     shell_exec("chmod 755 expectcmd");
		     $result = exec("./expectcmd");
		     if($result != 0){
		     		throw new BuildException("Couldn't pull from the git repository, please check for more details");
				}
		     else{
			return;
		     }
	      }

	      public function setRemote($remote){
	      	     $this->remote = $remote;
		}
	
		public function setPassword($password){
		       $this->password = $password;
		}

		public function setBranch($branch){
		       $this->branch = $branch;
		       }

		public function setPrompt($prompt){
		       $this->passwordPrompt = $prompt;
		       }

	}	

?>