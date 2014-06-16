var map = L.map('map').setView([-33.924868, 18.424055], 13);


L.tileLayer('http://{s}.tiles.mapbox.com/v3/lefrank.igohh385/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18
}).addTo(map);

$(document).ready(function() {
    $("input[type=text], textarea").val("");
    $("input[type=checkbox]").attr("checked",false);


    $("#getBrowserLocation").click(function() {
        $("#loading").show();
        geoFindMe();
    });

    $("#getUpdateBrowserLocation").click(function() {
        $("#loading").show();
        geoUpdate();
    });

    $("#saveCoordinates").click(function() {
        var lat = parseFloat($("#latitude").val());
        var lng = parseFloat($("#longitude").val());
        if ((lat < 90 && lat > -90) && (lng < 180 && lng > -180)) {
            var jqxhr = $.post("location/save", $("#co-ordinate-form").serialize()
                    ).done(function(data) {
                $("#status-message").html(data).show();
            }).fail(function(err) {
                alert("error" + err);
                console.log(err);
            });
        } else {
            alert("Invalid Latiude or Longitude provided.");
        }
    });


// GOOGLE STUFF, Thanks GOOGLE!
    var geocoder;
    var map;
    console.log(geocoder);

});
// Geocode stuff start
var geocoder = new google.maps.Geocoder();

function codeAddress() {
    if ($("#address").val() != "") {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $("#address").val(results[0].formatted_address);
                $("#latitude").val(results[0].geometry.location.k);
                $("#longitude").val(results[0].geometry.location.A);
//                var marker = L.marker([-33.9077472, 18.5654651]).addTo(map);
//                marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
                placeMarker(results[0].geometry.location.k, results[0].geometry.location.A);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    } else {
        alert("Please type an address above.");
    }
}

function geoFindMe() {
    var output = document.getElementById("out");
    if (!navigator.geolocation) {
        $("#browser-location").html("<p>Geolocation is not supported by your browser</p>");
        return;
    }

    function success(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $("#latitude").val(latitude);
        $("#longitude").val(longitude);
//        var img_src = "http://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";
//        $("#browser-location").html($("#browser-location").html() + "<img src='" + img_src + "' /><br/>");
        $("#loading").hide();
    }
    ;

    function error() {
        $("#browser-location").innerHTML = "Unable to retrieve your location";
        $("#status-message").html("Unable to retrieve your location").show();
        $("#loading").hide();
    }
    ;

    navigator.geolocation.getCurrentPosition(success, error);
}

function geoUpdate() {
    var output = document.getElementById("out");
    if (!navigator.geolocation) {
        $("#browser-location").html("<p>Geolocation is not supported by your browser</p>");
        return;
    }

    function success(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $("#latitude").val(latitude);
        $("#longitude").val(longitude);
        $("#map").attr("src", "http://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false").show();
        $("#loading").hide();
    }
    ;

    function error() {
        $("#browser-location").innerHTML = "Unable to retrieve your location";
        $("#loading").hide();
    }
    ;

    navigator.geolocation.getCurrentPosition(success, error);
}
// END GeoCode stuff
function editLocation(locationId) {
    $.post(
            "/location/get/" + locationId
            ).done(function(resp) {
        var obj = $.parseJSON(resp);
        console.log(obj);
        switch (obj.status) {
            case "1":
                $("#locationId").val(obj.location.id);
                $("#name").val(obj.location.name);
                $("#description").val(obj.location.description);
                $("#address").val(obj.location.address);
                console.log(obj.location.priority);
                if (obj.location.priority == 1) {
                    $("#priority").attr('checked', true);
                }else{
                    $("#priority").attr('checked', false);
                }
                $("#latitude").val(obj.location.latitude);
                $("#longitude").val(obj.location.longitude);
                var marker = L.marker([obj.location.latitude, obj.location.longitude]).addTo(map);
                map.setZoom(13);
                marker.bindPopup("<b>" + obj.location.name +
                        "</b><br>Address :" + obj.location.address).openPopup();
                break;
            case "0":

                break;
        }
        console.log(obj);
    });
}

function viewLocation(locationId, latitude, longitude) {
    map.panTo(new L.LatLng(latitude, longitude));
    $.post(
            "/location/get/" + locationId
            ).done(function(resp) {
        var obj = $.parseJSON(resp);
        console.log(obj);
        switch (obj.status) {
            case "1":
                $("#locationId").val(obj.location.id);
                $("#name").val(obj.location.name);
                $("#description").val(obj.location.description);
                $("#address").val(obj.location.address);
                $("#latitude").val(obj.location.latitude);
                $("#longitude").val(obj.location.longitude);
                var marker = L.marker([latitude, longitude]).addTo(map);
                map.setZoom(13);
                marker.bindPopup("<b>" + obj.location.name +
                        "</b><br>Address :" + obj.location.address).openPopup();
                break;
            case "0":

                break;
        }
        console.log(obj);
    });
}

function placeMarker(Lat, Long) {
    map.setZoom(13);
    map.panTo(new L.LatLng(Lat, Long));
    var marker = L.marker([Lat, Long]).addTo(map);
}

function clearFields() {
    $("input[type=text], textarea").val("");
}