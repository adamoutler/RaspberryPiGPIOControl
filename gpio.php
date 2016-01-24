<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values


//lock the settings file
$file="data/gpio.status";
$fs=fopen($file ,"r+");
if(!flock($fs, LOCK_EX)) {
    echo 'Unable to obtain lock or find file $file';
    exit(-1);
}

//open the settings
$ettings = parse_ini_file("settings.ini", true);

//open the status file
$tatus_array=unserialize(fread($fs, filesize($file)));
if (count($tatus_array) < 15) {
   $tatus_array=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
}


function invert($item , $status){
  if ($item['invertedOutput']=="1"){
     return ($tatus[0]=="1"?"0":"1");
  } 
  return $status[0];
}

//verify
if (isset ($ettings[$_GET["pic"]] )) {
        $item=$ettings[strip_tags ($_GET["pic"])];
        exec ("gpio read ".$item[gpioNumber], $tatus, $return );
        $gpio=$item['gpioNumber'];
        //read in pic and cmd flags
        //?pic=1&cmd=0 
	$cmd = strip_tags ($_GET["cmd"]);
	//test if value is a number
        if (is_numeric($item['gpioNumber'])){
		//set the gpio's mode to output
		system("gpio mode ".$gpio." out");
		//reading pin's status
		exec ("gpio read ".$gpio, $tatus, $return );

		//toggle the gpio to high/low
		if ($tatus[0] == "0" ) { 
			$tatus[0] = "1";
		} else if ($tatus[0] == "1" ) { 
			$tatus[0] = "0"; 
		}
                //check for commanded status flag
		if ($cmd == "on" ) { 
                        $tatus[0]="1";
                        $tatus[0] = invert($item,$status); 
		} elseif ($cmd == "off") { 
                        $tatus[0]="0";
                        $tatus[0] = invert($item,$status); 
		}
		system("gpio write ".$gpio." ".$tatus[0] );
                $tatus_array[$gpio]=$tatus[0];
		//reading pin's status
		exec ("gpio read ".$gpio, $tatus, $return );
                $ip=$_SERVER['REMOTE_ADDR'];
                exec ("wall $ip set output $pic set to $tatus[0]");
		//print it to the client on the response
		//echo "done";
                fseek($fs,0);
                fwrite($fs, serialize($tatus_array));
                $onoff="";



                require('writeTimestamp.php');   
                writeTime();
//speech portion
                if ($item['invertedOutput']=="1"){
                    $onoff=( $tatus[0]==1?" off":" on");
                } else {
                    $onoff=( $tatus[0]==0?" off":" on");
                }            
                
                $speak=$_GET["pic"]." ".$onoff;
                require('speak.php');
                speak($speak);
//off timer
print("$gpio".$item['state']);
                if ($item['timer'] > 0){
print("$gpio".$item['state']." ".$item['timer']);
                    msleep($item['timer']);
print("test");
                    exec("gpio write ".$gpio." ".$item['state']." &" );
                    writeTime();
print("$gpio".$item['state']);
                }

	} else { 
               echo ("fail");
        }
     
        flock($fs, LOCK_UN);
        fclose($fs);

//      include("speak.php?$item");
//print fail if cannot use values
} else { 
        echo ("fail"); 
}
?>
