<form action="location/save" id="co-ordinate-form" name="co-ordinate-form" method="POST" >
    <h3>Current Location</h3>
    <div id = "browser-location"></div>
    <input type = "hidden" name = "locationId" value = ""/>
    <label for = "name">Name</label>
    <input type = "text" placeholder = "Home, John's place" name = "name" value = "" />
    <br/>
    <label for = "description">Description</label>
    <textarea placeholder="Description" name = "description" ></textarea>
    <br/>
    <label for="address">Address</label>
    <textarea placeholder="Address" name="address"></textarea>
    <br/>
    <label for="priority">Priority</label>
    <input type="text" name="priority" value=""/>
    <br/>
    <label for="priority">Latitude</label>
    <input type="text" id="latitude" name="latitude" value=""/>° 
    <br/>
    <label for="longitude">Longitude</label>
    <input type="text" id="longitude" name="longitude" value=""/>°
    <br/>
    <br/>
    <img id="map" src="#" class="hidden"/>
    <br/>
    <input type="button" value="Refresh" id="getUpdateBrowserLocation"/> 
    &nbsp;
    <input type='button' value='Save' id='saveCoordinates'></input>
    <img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
</form>
<script type="text/javascript" src="/js/location/location.js" ></script>