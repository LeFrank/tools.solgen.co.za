<div class="row expanded">
    <div class="large-4 columns" >
        <form action="location/save" id="co-ordinate-form" name="co-ordinate-form" method="POST" >
            <h3>Location Details    </h3><a name="capture-form" />
            <input type="button" class="button secondary tiny" value="New" id="newLocation" onclick="clearFields()"/> 
            <br/>
            <input type = "hidden" id="locationId" name="locationId" value = ""  />
            <label for = "name">Name *</label>
            <input type = "text" placeholder="Home, John's place" id="name" name="name" value = "" autofocus/>
            <br/>
            <label for = "description">Description</label>
            <textarea placeholder="Description" id="description" name = "description" ></textarea>
            <br/>
            <label for="address">Address</label>
            <textarea placeholder="Address" name="address" id="address"></textarea>
            <br/><br/>
            <input type="button" class="button secondary tiny" value="Get Formatted Address" onclick="codeAddress()">
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
            <label for="telephone">Telephone</label>
            <input type="text" id="telephone" name="telephone" value=""/>°
            <br/>
            <label for="mobile">Mobile</label>
            <input type="text" id="mobile" name="mobile" value=""/>°
            <br/>
            <label for="fax">Fax</label>
            <input type="text" id="fax" name="fax" value=""/>°
            <br/>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value=""/>°
            <br/>
            <label for="operating_hours">Operating Hours</label>
            <textarea placeholder="Mon - Fri: 09:00 to 20:00" id="operating_hours" name="operating_hours" value=""></textarea>
            <br/>
            <label for="website">Website</label>
            <textarea placeholder="Http://tools.solgen.co.za" id="website" name="website" value=""></textarea>
            <br/>
            <br/>
            <input type='button' class="button" value='Save' id='saveCoordinates'></input>
            &nbsp;
            <input type="button" class="button secondary" value="Here" id="getUpdateBrowserLocation"/> 
            <img src="/images/third_party/thickbox/loadingAnimation.gif" class="hidden" id="loading" />
        </form>
    </div>
    <div class="large-8 columns">
        <div id="browser-location"></div>
        <div id="map"/>
    </div>
</div>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDCepEyRu0S_8FEXebz7uHttja8Wt6l8xc&sensor=FALSE"></script>
<script type="text/javascript" src="/js/location/location.js" ></script>
