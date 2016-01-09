<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="theme.css">
        <meta charset="utf-8" />
        <title>Raspberry Pi Gpio</title>
    </head>
    <body>
	<?php
	$val_array = array(0,0,0,0,0,0,0,0);
        $name_array = array("Router","Modem","Server","3","4","5","6","7","8");
	//this php script generate the first page in function of the file
	for ( $i= 0; $i<8; $i++) {
		//set the pin's mode to output and read them
		system("gpio mode ".$i." out");
		exec ("gpio read ".$i, $val_array[$i], $return );
	}
	//for loop to read the value
	$i =0;
	for ($i = 0; $i < 8; $i++) {
		//if off
		if ($val_array[$i][0] == 0 ) {
			echo ("<div class='redImageContainer' id='button_".$i."' onclick='change_pin(".$i.");'><div  class='caption'>".$name_array[$i]."</div></div>\n	");
		}
		//if on
		if ($val_array[$i][0] == 1 ) {
                        echo ("<div class='greenImageContainer' id='button_".$i."' onclick='change_pin(".$i.");'><span class='caption'>".$name_array[$i]."</span></div>\n	");
		}
	}?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script src="script.js"></script>
    </body>
</html>
