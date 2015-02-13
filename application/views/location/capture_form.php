<div style="float:left;width:400px;">
    <form action="location/save" id="co-ordinate-form" name="co-ordinate-form" method="POST" >
        <h3>Location Details    </h3>
        <input type="button" value="New" id="newLocation" onclick="clearFields()"/> 
        <br/>
        <input type = "hidden" id="locationId" name="locationId" value = ""/>
        <label for = "name">Name *</label>
        <input type = "text" placeholder="Home, John's place" id="name" name="name" value = "" />
        <br/>
        <label for = "description">Description</label>
        <textarea placeholder="Description" id="description" name = "description" ></textarea>
        <br/>
        <label for="address">Address</label>
        <textarea placeholder="Address" name="address" id="address"></textarea><br/>
        <label for=" ">&nbsp;&nbsp;&nbsp;</label><input type="button" value="Get Formatted Address" onclick="codeAddress()">
        <br/>
        <label for="priority">Default</label>
        <input type="checkbox" id="priority" name="priority" value="1"/>
        <br/>
        <label for="priority">Latitude *</label>
        <input type="text" id="latitude" name="latitude" value=""/>° 
        <br/>
        <label for="longitude">Longitude *</label>
        <input type="text" id="longitude" name="longitude" value=""/>°
        <br/>
        <br/>
        <br/>
        <input type="button" value="Here" id="getUpdateBrowserLocation"/> 
        &nbsp;
        <input type='button' value='Save' id='saveCoordinates'></input>
        <img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
    </form>
</div>
<div style="float:left;width:45%;margin-top:80px;">
    <div id="browser-location"></div>
    <div id="map"/>
</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDCepEyRu0S_8FEXebz7uHttja8Wt6l8xc&sensor=FALSE"></script>

<script type="text/javascript" src="/js/location/location.js" ></script>
