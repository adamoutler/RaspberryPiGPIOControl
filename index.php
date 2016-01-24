<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="data/css/theme.css">
        <meta charset="utf-8" />
        <title>Raspberry Pi Gpio</title>
    </head>
    <body>
	<?php

        $ettings = parse_ini_file("settings.ini", true);
        $val_array = array(0,0,0,0,0,0,0,0);



foreach ($ettings as $section_key => $section ){
      if ($section['enabled']=="0"){
          continue;
      }
      system("gpio mode ".$section['gpioNumber']." out");
      $value=exec ("gpio read ".$section['gpioNumber'], $retval, $return);
      if ($section[invertedOutput]=="1"){
         $out=($value == "1" ? -1 : 1);
      }
      echo "<div class='".($out == '-1' ?'redImageContainer':'greenImageContainer')."' id='".$section_key."' inverted='".$section['invertedOutput']."'  onclick='change_pin(\"".$section_key."\");'><div  class='caption'>".$section_key."</div></div>\n	" ;
   
}

?>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script src="data/js/script.js"></script>
    </body>
</html>
