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
                    echo    "<td>" . (($location->priority == 1 )?"default":"")."</td>";
                    echo    "<td><a href='#' onclick='viewLocation(".$location->id.",\"".$location->latitude."\",\"".$location->longitude."\");'>View</a> "
                            . "| <a href='#' onclick='editLocation(".$location->id.");'>Edit</a> "
                            . "| <a href='/location/delete/".$location->id."'>Delete</a></td>";
                    echo "</tr>";
                    $count++;
                }?>
            </tbody>
        </table>
<?php } ?>
