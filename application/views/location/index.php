<div id="status-message" class="hidden"></div>
<?php
if (empty($locations)) {
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
   
        <h3>Saved Locations</h3>
        <table class="location_list_table">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Address</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Priority</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php
                $count =1;
                foreach ($locations as $location) {
                    echo "<tr>";
                    echo    "<td>".$count."</td>";
                    echo    "<td>" . $location->name."</td>";
                    echo    "<td>" . $location->description."</td>";
                    echo    "<td>" . $location->address."</td>";
                    echo    "<td>" . $location->latitude . "°"."</td>";
                    echo    "<td>" . $location->longitude . "°"."</td>";
                    echo    "<td>" . $location->priority."</td>";
                    echo    "<td><a href='/location/view/".$location->id."'>View</a> | <a href='/location/edit/".$location->id."'>Edit</a> | <a href='/location/delete/".$location->id."'>Delete</a></td>";
                    echo "</tr>";
                    $count++;
                }?>
            </tbody>
        </table>
<?php } ?>
