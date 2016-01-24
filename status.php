<?php
$ettings = (array)parse_ini_file("settings.ini", true);
foreach ($ettings as $section_key => $section ){
      if ($section['enabled']=="0"){
          $section['state']=1;
          continue;
      }
      $value=exec ("gpio read ".$section['gpioNumber'], $retval, $return); 
      if ($section['invertedOutput']==1){

         $value=$value=="1"?0:1;
//echo "$value";
      }
      $ettings[$section_key][state]=$value;
}
//$output=str_replace('}',']',str_replace($ettings,'{','['));
print(json_encode((array)$ettings));

