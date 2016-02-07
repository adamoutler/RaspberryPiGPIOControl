//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi


function target(target) {
    var data = 0;
    //send the target number to gpio.php for changes
    var request = new XMLHttpRequest();
    request.open("GET", "Dispatch.php?target=" + target, true);
    request.send(null);
    //receiving informations
    document.getElementById(target).className = (document.getElementById(target).className == "greenImageContainer" ? "redImageContainer" : "greenImageContainer");
 


    request.onreadystatechange = function() {
        if ( request.readyState==4 && request.status == 200) {
            var text=request.responseText;
            if (text=="0") {text="off"};
            if (text=="1") {text="on"};
            document.getElementById("output").innerHTML = target+" commanded "+text ;
            $('.error').fadeIn(400).delay(3000).fadeOut(400);
            refresh();
        }
        
    }

    return 0;
}

var timestamp=0
setInterval(refresh, 1000);
function refresh() {

    var updateCheck= new XMLHttpRequest();
    updateCheck.open("GET", "data/lastChange?v=1", true);
    updateCheck.send(null);
    updateCheck.onreadystatechange = function(){
        if (updateCheck.readyState == 4 && updateCheck.status == 200) {
             currenttimestamp=updateCheck.responseText;
             if (currenttimestamp>timestamp){
                 timestamp=currenttimestamp;
                 var request = new XMLHttpRequest();
                 request.open("GET", "status.php?v=1", true);
                 request.send(null);
        //receiving informations
                 request.onreadystatechange = function() {
                 if (request.readyState == 4 && request.status == 200) {
                    var status = JSON.parse(request.responseText);

                    for (var item in status) {
                        document.getElementById(item).className = 
                        (status[item].state == 0 ? "redImageContainer" : "greenImageContainer");
                    }
    
                 }
             }
          }
    }
}
}
