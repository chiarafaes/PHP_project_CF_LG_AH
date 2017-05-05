var x = document.getElementById("demo");

function ready()
{

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude +
        "<br>Longitude: " + position.coords.longitude;

    var var1 = position.coords.latitude;
    var var2 = position.coords.longitude;

    var r = httpGet("https://maps.googleapis.com/maps/api/geocode/json?latlng="+var1+","+var2+"&sensor=false");
    x.innerHTML = getAddress(r);
}

function httpGet(theUrl)
{
    var xmlHttp = null;

    xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false );
    xmlHttp.send( null );
    return xmlHttp.responseText;
}

function getAddress(response)
{
    var obj = jQuery.parseJSON(response);
    return obj.results[2].formatted_address;
}