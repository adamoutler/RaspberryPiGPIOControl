<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it
//Getting and using values



//read a value from the GPIO return 1 if high, 0 if low
function readGPIO($target){
    return invert($target, exec("/usr/bin/gpio read ".$target["gpioNumber"] ));
}

//writes a target GPIO with a commanded state, 1 if high, 0 if low.  Returns commanded state
function writeGPIO($target, $state){
    return invert($target, exec("/usr/bin/gpio write ".$target["gpioNumber"]." ".invert($target, $state) ));
}

//writes the default value to the target
function writeDefaultToGPIO($target){
    $state=$target['state'];
    return writeGPIO($target, $state);
}

//sets gpio modes
function setmode($target, $mode){
    return system("/usr/bin/gpio mode ".$target["gpioNumber"]." $mode" );
}


//Takes the settings, a target, and performs an operation.
function gpio($ettings, $target){
    $tatus=readGPIO($target);
    $gpio=$target['gpioNumber'];

    //read in cmd flag if set
    $cmd= isset($_GET["cmd"]) ? $_GET["cmd"]  : null;

    //test if value is a number
    if (is_numeric($target['gpioNumber'])){
        //set the gpio's mode to output
        setMode($target, "out");

        //toggle the gpio to high/low
        $tatus=($tatus=="0" ? 1 : 0);

        //check for commanded status flag and act upon it.
        if (isset($cmd)){
            $tatus=($cmd=="off"? 0:1);
        }
        writeGPIO($target,$tatus);
    //reading pin's status
        $status=readGPIO($target);
        writeTimeStamp();

        //only wait to change state if default state is not current state
        if ($target['state'] != readGPIO($target)){
            if (isset($target['timer']) && $target['timer'] > 0){
                 usleep($target['timer']*1000000);
                 writeDefaultToGPIO($target);
            }
        }
    } else {
        echo ("fail");
    }
    writeTimeStamp();
}


?>
