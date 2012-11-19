<?php
	class PullTask extends Task {	      
	      protected $remote = NULL;
	      protected $password = NULL;
	      protected $branch = NULL;
	      protected $passwordPrompt = NULL;

	      /*Performs any one-time initalization, doesn't do anything in this case*/
	      public function init() {}

	      /*This is what is actually called when the task happens*/
	      public function main(){
	      	     $expect_file = "expectcmd";
		     $expect_file_result = $this->createExpectFile($expect_file); //generate an expect file to do the pull process
		     if(!$expect_file_result){
				throw new BuildException("Error, could not create the expect file.  Please make sure you can create files in this directory");
			}
		     exec("chmod 755 $expect_file");
		     $output = array();
		     $result = exec("./$expect_file", $output);

		     for($i = 0; $i < count($output); $i++){
		     	    echo $output[$i] . "\n";
			    }
			    

		     if($result != 0){ //if there was an error, throw an exception
		     		throw new BuildException("Couldn't pull from the git repository, please check for more details");
			}
		     else{
			exec("rm $expect_file");
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

		private function createExpectFile($fileName){
			$fh = fopen ("$fileName", "w+");
			if(!$fh){
				return FALSE;
			}
		     	fwrite($fh, "#!/usr/bin/expect -f\n");
		     	fwrite($fh, "spawn git pull origin master\n");
		     	fwrite($fh, "expect {\n");
		     
			$password_string = $this->password . "\\r";
		     	fwrite($fh, " \"$this->passwordPrompt\"   {send  \"$password_string\" \n  expect eof }\n");
		     	fwrite($fh, "\"Already up-to-date\" {exit 0}\n");
		     	fwrite($fh, "default          {exit 1}\n");
		     	fwrite($fh, "}\n");
		     	fclose($fh);
		     	return TRUE;
		}
	}	

?>