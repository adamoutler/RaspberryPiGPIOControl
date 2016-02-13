<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="resources/css/theme.css">
        <meta charset="utf-8" />
        <title>Raspberry Pi Gpio</title>
        <meta name="theme-color" content="#000000">
        <meta name="msapplication-navbutton-color" content="#000000">
        <meta name="apple-mobile-web-app-status-bar-style" content="#000000">
        <link rel="icon" sizes="192x192" href="resources/img/green.jpg">


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
      echo "<div class='".($out == '-1' ?'redImageContainer':'greenImageContainer')."' id='".$section_key."' inverted='".$section['invertedOutput']."'  onclick='target(\"".$section_key."\");'><div  class='caption'>".$section_key."</div></div>\n	" ;
}

?>
        <div id="output" class="error" style="display:none"></div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript" async></script>
	<script src="resources/js/script.js" async></script>
    </body>
</html>
