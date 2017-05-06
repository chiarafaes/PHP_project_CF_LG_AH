$(document).ready(function(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation);
    } else {
        $('#location').html('Geolocation is not supported by this browser.');
    }
});

function showLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
        url:"ajax/ajax.markinappropriote.php",
        method:"post",
        data:{
            "latitude" : latitude,
            "longitude": longitude,
            "id": id
        },
        success:function(msg){
            if(msg){
                $("#location").html(msg);
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}