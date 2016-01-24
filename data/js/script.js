//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//JavaScript, uses pictures as buttons, sends and receives values to/from the Rpi


function change_pin(pic) {
    var data = 0;
    //send the pic number to gpio.php for changes
    var request = new XMLHttpRequest();
    request.open("GET", "gpio.php?pic=" + pic, true);
    request.send(null);
    //receiving informations
    document.getElementById(pic).className = 
         (document.getElementById(pic).className == "greenImageContainer" ? "redImageContainer" : "greenImageContainer");
    request.onreadystatechange = function() {
        var request = new XMLHttpRequest();
        request.open("GET", "status.php", true)
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                refresh();
            } else if (request.readyState == 4 && request.status == 500) {
                alert("server error");
                return ("fail");
            } else if (request.readyState == 4 && request.status != 200 && request.status != 500) {
                alert("Could not perform request.");
                return ("fail");
            }
        }
    }

    return 0;
}

var timestamp=0
setInterval(refresh, 1000);
function refresh() {
    var updateCheck= new XMLHttpRequest();
    updateCheck.open("GET", "data/lastChange", true);
    updateCheck.send(null);
    updateCheck.onreadystatechange = function(){
        if (updateCheck.readyState == 4 && updateCheck.status == 200) {
             currenttimestamp=updateCheck.responseText;
             if (currenttimestamp>timestamp){
                 timestamp=currenttimestamp;
                 var request = new XMLHttpRequest();
                 request.open("GET", "status.php", true);
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
