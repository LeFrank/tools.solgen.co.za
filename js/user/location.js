$(document).ready(function() {
    $("#getBrowserLocation").click(function() {
        $("#loading").show();
        geoFindMe();
    });

    $("#getUpdateBrowserLocation").click(function() {
        $("#loading").show();
        geoUpdate();
    });


    $("#saveCoordinates").click(function() {
        var jqxhr = $.post("/user/location/save", $("#co-ordinate-form").serialize()
                ).done(function(data) {
            $("#status-message").html(data).show();
        }).fail(function(err) {
            alert("error" + err);
            console.log(err);
        });
    });

});

function geoFindMe() {
    var output = document.getElementById("out");
    if (!navigator.geolocation) {
        $("#browser-location").html("<p>Geolocation is not supported by your browser</p>");
        return;
    }

    function success(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        var latInput = '<input type="hidden" name="latitude" value="' + latitude + '"/>';
        var lngInput = '<input type="hidden" name="longitude" value="' + longitude + '"/>';
        $("#browser-location").html('<p>Latitude is ' + latitude + '° <br>Longitude is ' + longitude + '°</p>' + latInput + lngInput);
        var img_src = "http://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false";
        var saveBtn = "<input type='button' value='Save' id='saveCoordinates'></input>";
        $("#browser-location").html($("#browser-location").html() + "<img src='" + img_src + "' /><br/>" + saveBtn);
        $("#loading").hide();

        $("#saveCoordinates").click(function() {
            var jqxhr = $.post("/user/location/save", $("#co-ordinate-form").serialize()
                    ).done(function(data) {
                $("#status-message").html(data).show();
            }).fail(function(err) {
                alert("error" + err);
                console.log(err);
            });
        });
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
        $("#map").attr("src","http://maps.googleapis.com/maps/api/staticmap?center=" + latitude + "," + longitude + "&zoom=13&size=300x300&sensor=false");
        $("#loading").hide();
    };

    function error() {
        $("#browser-location").innerHTML = "Unable to retrieve your location";
        $("#loading").hide();
    };

    navigator.geolocation.getCurrentPosition(success, error);
}