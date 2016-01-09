<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->
<?php
    $url1=$_SERVER['REQUEST_URI'];
    $refresh= strip_tags ( $_GET["refresh"]);   
    if ( empty($refresh) ){ $refresh = 10; }
 header("Refresh: $refresh; URL=$url1");
?>
<html>
    <head>
        <style>
 .redImageContainer {
       width:220px; 
       height:270px; 
       background-image: url("data/img/red.jpg");
       float: left;
       position: relative;
       display:inline-block;

 }
 .greenImageContainer {
       width:220px; 
       height:270px; 
       background-image: url("data/img/green.jpg");
       float: left;
       position: relative:
       display:inline-block;
 }

.caption {
color: white;
font: bold 24px/45px Helvetica, Sans-Serif;
letter-spacing: 1px;
background: rgb(0, 0, 0); /* fallback color */
background: rgba(0, 0, 0, 0.2);
width: 92%;
position: absolute;
top: 130px;
margin-left: 60px

}

        </style>
        <meta charset="utf-8" />
        <title>Raspberry Pi Gpio</title>
    </head>
 
    <body style="background-color: black;">
    <!-- On/Off button's picture -->
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
			echo ("<div class='redImageContainer' id='button_".$i."' onclick='change_pin(".$i.");'><div class='caption'>".$name_array[$i]."</div></div>\n");
		}
		//if on
		if ($val_array[$i][0] == 1 ) {
                        echo ("<div class='greenImageContainer' id='button_".$i."' onclick=\"change_pin(".$i.");\" ><div class='caption'>".$name_array[$i]."</div></div>\n");
		}
	}
	?>
	<!-- javascript -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script src="script.js"></script>
    </body>
</html>
