<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values



//read a value from the GPIO
function readGPIO($target){

    return invert($target, system("/usr/bin/gpio read ".$target["gpioNumber"] ));
}

//the actual value to be written to the GPIO
function writeGPIO($target, $state){
    return invert($target, system("/usr/bin/gpio write ".$target["gpioNumber"]." ".invert($target, $state) ));
}

function writeDefaultToGPIO($target){
    $state=$target['state'];
    writeGPIO($target, $state);
}

//sets gpio modes
function setmode($target, $mode){
    return system("/usr/bin/gpio mode ".$target["gpioNumber"]." $mode" );
}


//verify
function gpio($ettings, $target, $fs ){
    $tatus=readGPIO($target);
    $gpio=$target['gpioNumber'];
    //read in pic and cmd flags
    //?pic=1&cmd=0
    $cmd= isset($_GET["cmd"]) ? $_GET["cmd"]  : null;



    //test if value is a number
    if (is_numeric($target['gpioNumber'])){
        //set the gpio's mode to output
        setMode($target, "out");
        //reading pin's status
        //toggle the gpio to high/low
        

$ss="0";
$st="1";

$ss=$ss-1;
$st=$st-1;

if ($ss){
echo "ss=true $ss";
}
if ($st){
echo "st=true $st";
}
            
        $tatus=($tatus=="0" ? 1 : 0);
        //check for commanded status flag
        if ($cmd == "on" ) {
            $tatus="1";
            $tatus=invert($target,$tatus);
        } elseif ($cmd == "off") {
            $tatus="0";
            $tatus = invert($target,$tatus);
        }
        writeGPIO($target,$tatus);
    //reading pin's status
        $status=readGPIO($target);
        fseek($fs,0);
        writeTimeStamp();
        if (isset($target['timer']) && $target['timer'] > 0){
             usleep($target['timer']*1000000);
             writeDefaultToGPIO($target);
        }
    } else {
        echo ("fail");
    }
    writeTimeStamp();
}


?>
