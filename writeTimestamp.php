<?php
function writeTime(){
    $ts = "data/lastChange";
    $fh = fopen($ts, 'w');
    $time=time();
    fwrite($fh, $time);
    fclose($fh);
}
?>
