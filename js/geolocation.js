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
        url:"ajax/ajax.getLocation.php",
        method:"post",
        data:{
            "latitude" : latitude,
            "longitude": longitude
        },
        success:function(msg){
            if(msg){
                $("#location").val(msg);
            }else{
                $("#location").val('Not Available');
            }
        }
    });
}