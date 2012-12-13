#!/usr/bin/env bash

function exec_and_test {
	$1 #run whatever command was passed in
	
	if [ $? != 0 ] #if it has a nonzero exit code, exit with value 1
		then
			echo $2
			exit 1
	fi
}

if [ "$PHING_HOME" == "" ] #Check that phing home is defined
	then
		echo "Phing home is not currently defined, please write it into your bashrc"
		exit 1
else
	echo "PHING_HOME exists, continuing with the installation"
fi

if [ ! -e $PHING_HOME/tasks/custom ] #Check if the custom tasks folder exists already
	then
		exec_and_test "mkdir $PHING_HOME/tasks/custom" "Couldn't create a custom tasks folder, try again with sudo??"
	fi


echo "Custom tasks folder exists or was successfully created"

if [ ! -e $PHING_HOME/lib ] #create the lib folder if necessary
	then
		exec_and_test "mkdir $PHING_HOME/lib" "Couldn't create a lib folder, try again with sudo??"
fi 

echo "lib folder was created or already exists"

exec_and_test "cp customTasks/*Task.php $PHING_HOME/tasks/custom" "Unable to move task files to the custom tasks folder, perhaps run this as root??"
exec_and_test "cp -R phpseclib $PHING_HOME/lib" "Couldn't copy over phpseclib to our lib folder"


echo "Sucessfully got everything up to speed"

