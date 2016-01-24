<?php

$ettings = (array)parse_ini_file("settings.ini", true);
$file="data/gpio.status";
$fs=fopen($file , "r+" );
if(!flock($fs, LOCK_EX | LOCK_NB)) {
    echo 'Unable to obtain lock';
    exit(-1);
}
$status_array=unserialize(fread($fs, filesize($file)));
if (count($status_array) < 15) {
   $status_array=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
}



for ($i = 1; $i < count($status_array); $i++) {
    system("gpio mode ".$i." out");
    system("gpio write ".$i." ".$status_array[$i] );

    echo "set output $i to $status_array[$i]<br>\n";
}
fseek($fs,0);
fwrite($fs, serialize($status_array));
flock($fs, LOCK_UN);
fclose($fs);

?>
