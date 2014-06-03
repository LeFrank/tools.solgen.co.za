<div id="status-message" class="hidden"></div>
<?php
if (empty($location)) {
    ?>
    <h3>
        Latitude and Longitude.
    </h3>
    <p>By Capturing your latitude and longitude, 
        <br/>
        some of tools will be able to provide more accurate results.<br/>
        Tools : Weather
    </p>
    <br/><br/>
    Find location : <input type="button" value="Get Location From Browser" id="getBrowserLocation"/> 
    <br/>
    <br/>
    <img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
    <form action="/user/location/save" id="co-ordinate-form" name="co-ordinate-form" method="POST">
        <div id="browser-location"></div>
    </form>
<?php } else { ?>
    <form action="/user/location/save" id="co-ordinate-form" name="co-ordinate-form" method="POST" >
        <h3>Current Location</h3>
        <div id="browser-location"></div>
        <input type="hidden" name="locationId" value="<?php echo $location->id; ?>"/>
        <p>Latitude is <input type="text" id="latitude" name="latitude" value="<?php echo $location->latitude; ?>"/>° 
            <br>
            Longitude is <input type="text" id="longitude" name="longitude" value="<?php echo $location->longitude; ?>"/>°</p>
        <img id="map" src='http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $location->latitude; ?>,<?php echo $location->longitude; ?>&zoom=13&size=300x300&sensor=false' />
        <br/>
        <input type="button" value="Refresh" id="getUpdateBrowserLocation"/> 
        &nbsp;
        <input type='button' value='Save' id='saveCoordinates'></input>
        <img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
    </form>
<?php } ?>
<script type="text/javascript" src="/js/user/location.js" ></script>