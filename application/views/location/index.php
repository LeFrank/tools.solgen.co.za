<div class="row expanded" id="location-content">
    <div class="large-12 columns">
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
        <div class="large-12 columns">
            <div class="large-9 columns">
                <h3>Saved Locations</h3>
            </div>
            <div class="large-3 columns">
                <form>
                    <div class="row collapse">
                        <div class="large-9 columns">
                            <input type="search" name="search" id="search" placeholder="search">
                        </div>
                        <div class="large-3 columns">
                            <span class="postfix" id="searchBtn"><i class="fi-magnifying-glass"></i></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="result_table">
            <div class="pagination-centered">
                <?php
                echo $this->pagination->create_links();
                ?>
            </div>
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
                    $count = 1;
                    foreach ($locations as $location) {
                        echo "<tr>";
                        echo "<td>" . (($per_page * $cur_page ) - 10  + $count) . "</td>";
                        echo "<td><a href='#capture-form' onclick='viewLocation(" . $location->id . ",\"" . $location->latitude . "\",\"" . $location->longitude . "\");'>" . $location->name . "</a></td>";
                        echo "<td>" . $location->description . "</td>";
                        echo "<td>" . $location->address . "</td>";
                        echo "<td>" . $location->latitude . "°" . "</td>";
                        echo "<td>" . $location->longitude . "°" . "</td>";
                        echo "<td>" . (($location->priority == 1 ) ? "default" : "") . "</td>";
                        echo "<td><a href='#capture-form' onclick='viewLocation(" . $location->id . ",\"" . $location->latitude . "\",\"" . $location->longitude . "\");'>View</a> "
                        . "| <a href='#capture-form' onclick='editLocation(" . $location->id . ");'>Edit</a> "
                        . "| <a href='/location/delete/" . $location->id . "' onclick='return confirm_delete()'>Delete</a></td>";
                        echo "</tr>";
                        $count++;
                    }
                    ?>
                </tbody>
                </table>
                <div class="pagination-centered">
                    <?php
                    echo $this->pagination->create_links();
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>