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
                $("#location-content").replaceWith(data);
                $('html, body').animate({ scrollTop: 0 }, 0);
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

});
// Geocode stuff start
var geocoder = new google.maps.Geocoder();

function codeAddress() {
    if ($("#address").val() != "") {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var lat ="";
                var lng = "";
                $("#address").val(results[0].formatted_address);
                $("#latitude").val(results[0].geometry.location.k);
                lat = results[0].geometry.location.k;
                console.log(results[0].geometry.location.A);
                if(undefined != results[0].geometry.location.A){
                    lng = results[0].geometry.location.A;
                    $("#longitude").val(results[0].geometry.location.A);
                }else{
                    lng = results[0].geometry.location.B;
                    $("#longitude").val(results[0].geometry.location.B);
                }
                placeMarker(lat, lng);
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
        placeMarker(latitude, longitude);
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
        }
    });
}

function viewLocation(locationId, latitude, longitude) {
    map.panTo(new L.LatLng(latitude, longitude));
    $.post(
            "/location/get/" + locationId
            ).done(function(resp) {
        var obj = $.parseJSON(resp);
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
        }
    });
}

function placeMarker(Lat, Long) {
    map.setZoom(13);
    map.panTo(new L.LatLng(Lat, Long));
    var marker = L.marker([Lat, Long],{draggable: true}).addTo(map);
    marker.on('dragend', function(e){
        $("#latitude").val(e.target._latlng.lat);
        $("#longitude").val(e.target._latlng.lng);
    });
}


function clearFields() {
    $("input[type=text], input[type=hidden], textarea").val("");
}