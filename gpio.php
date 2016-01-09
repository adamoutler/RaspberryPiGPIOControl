<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values

$file="gpio.status";
$fs=fopen($file ,"r+");
if(!flock($fs, LOCK_EX)) {
    echo 'Unable to obtain lock or find file $file';
    exit(-1);
}
$status_array=unserialize(fread($fs, filesize($file)));
if (count($status_array) < 7) {
   $status_array=array(0,0,0,0,0,0,0,0);
}


if (isset ( $_GET["pic"] )) {
        //read in pic and cmd flags
        //?pic=1&cmd=0 
	$pic = strip_tags ($_GET["pic"]);
	$cmd = strip_tags ($_GET["cmd"]);
	//test if value is a number
	if ( (is_numeric($pic)) && ($pic <= 7) && ($pic >= 0) ) {

		//set the gpio's mode to output
		system("gpio mode ".$pic." out");
		//reading pin's status
		exec ("gpio read ".$pic, $status, $return );

		//toggle the gpio to high/low
		if ($status[0] == "0" ) { 
			$status[0] = "1";
		} else if ($status[0] == "1" ) { 
			$status[0] = "0"; 
		}

                //check for commanded status flag
		if ($cmd == "on" ) { 
			$status[0] = "1"; 
		}elseif ($cmd == "off") { 
			$status[0] = "0";  
		}

		system("gpio write ".$pic." ".$status[0] );
                $status_array[$pic]=$status[0];
		//reading pin's status
		exec ("gpio read ".$pic, $status, $return );
		//print it to the client on the response
		echo($status[0]);

	} else { echo ("fail"); }

fseek($fs,0);
fwrite($fs, serialize($status_array));
flock($fs, LOCK_UN);
fclose($fs);
//print fail if cannot use values
} else { echo ("fail"); }
?>
