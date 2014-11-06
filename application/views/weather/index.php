<?php
if (empty($myWeather)) {
    ?>
    <div id="forecast-section">
        <h3>No Locations To View Weather For</h3>
        <p>
            Please goto the <a href="/locations" >Locations </a> section and add a location or locations of interest.<br/>
            This will enable us to retrieve the required weather data.
        </p>
    </div>
<?php
} else {
    ?>
    <div id="forecast-section">
        <h3>Default Location : <?php echo $myWeather[0]["location"]->name ." - ".$myWeather[0]["location"]->description; ?> </h3>
        <div id="weather-data">
            <table class="weather-forecast" >
                <thead>
                    <?php
                    foreach ($myWeather[0]["weather"]->list as $k => $v) {
                        echo "<th>";
                        echo date("l", $v->dt) . ", " . date("d M Y", $v->dt)
                        . "</th>";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($myWeather as $k => $v) {
                        echo "<tr>";
                        foreach ($v["weather"]->list as $kk => $vv) {
                            echo "<td >";
                            echo "<div style='text-align:center;'>";
                            echo ucwords($vv->weather[0]->description) . " <br/>";
                            echo "<img src='http://openweathermap.org/img/w/" . $vv->weather[0]->icon . ".png'>"
                            . "</div>";
                            echo "<span class='span-label'>" . round($vv->temp->max) . 
                                    $measure[$weatherSettings->measurement].
                                    " |</span>" . 
                                    round($vv->temp->min) . 
                                    $measure[$weatherSettings->measurement]."<br/>";
                            echo "<span class='span-label'>Morning :</span>" . $vv->temp->morn . "<br/>";
                            echo "<span class='span-label'>Mid Day :</span>" . $vv->temp->day . "<br/>";
                            echo "<span class='span-label'>Evening :</span>" . $vv->temp->eve . "<br/>";
                            echo "<span class='span-label'>Pressure :</span>" . $vv->pressure . " hpa<br/>";
                            echo "<span class='span-label'>Humidity :</span>" . $vv->humidity . " %<br/>";
                            echo "<span class='span-label'>Wind Speed :</span>" . $vv->speed . " m/s <br/>";
                            echo "<span class='span-label'>Wind Direction :</span>" . $vv->deg . "°<br/>";
                            echo "<span class='span-label'>Cloud Cover :</span>" . $vv->clouds . " %<br/>";
                            echo "<span class='span-label'>Rain :</span>" . ((property_exists($vv, 'rain')) ? $vv->rain . " mm" : "none") . "<br/>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        $count++;
                        if ($count == sizeOf($myWeather)) {
                            break;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>



