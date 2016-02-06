<?php
//get settings from file
function init(){
   $settings=parse_ini_file("settings.ini", true);
   return $settings;
}



//lock the file for read/write and exit if not possible
function lockStatusFile($file) {
    
    //lock the settings file
    $fs=fopen($file ,"w");
    if(!flock($fs, LOCK_EX |LOCK_NB)) {
        echo "I'm busy because $file is locked";
        exit(-1);
    }
    return $fs;
}

function unlockStatusFile($fs){
    flock($fs, LOCK_UN);
    fclose($fs);
}


