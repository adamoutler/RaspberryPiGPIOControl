<?php
require('Settings.php');

//lock the settings file
$file="data/gpio.status";
//open the settings
$ettings=init();


$fs=lockStatusFile($file);
//open the status file

function invert($item, $tate){
  if ($item['invertedOutput']=="1"){
     return ($tate=="1"?"0":"1");
  }
  return $tate;
}



foreach ($argv as $arg) {
         $e=explode("=",$arg);
        if(count($e)==2){
            $_GET[$e[0]]=$e[1];
        }else{
            $_GET[]=$e[0];
       }
    }




function  dispatch($ettings, $fs){

    if (isset($_GET["target"])){
        $name=$_GET["target"];
        if (array_key_exists($name , $ettings)){
            $target=$ettings["$name"];
            if ($target["type"] == "gpio"){
                require ("GPIO.php");
                gpio($ettings, $target, $fs);
            }else {
                echo "I can't handle anything except GPIOs right now  ".$target['type']."<br>\n";
            }
        } else {
            echo "invalid setting $name<br>\n";
        }
    } else {
        echo "no parameters specified to dispatch<br>\n";
    }
}

//echo "mytarget: $target\n";

include_once('writeTimestamp.php');
dispatch($ettings, $fs);
unlockStatusFile($fs);
writeTimeStamp();
