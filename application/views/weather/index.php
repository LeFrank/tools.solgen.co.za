<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//echo "<pre>";
//print_r($user);
//print_r($this->weatherApiDetails);\
//echo "<pre>";
//print_r($myWeather);
//echo "</pre>";
?>
<table class="weather-forecast" >
    <thead>
        <?php
        foreach ($myWeather->list as $k => $v) {
            echo "<th>";
            echo date("l", $v->dt) . ", " . date("d M Y", $v->dt)
            . "</th>";
        } ?>
    </thead>
    <tbody>
        <tr>
            <?php
            foreach ($myWeather->list as $k => $v) {
                echo "<td >";
                echo "<div style='text-align:center;'>";
                echo ucwords($v->weather[0]->description) . " <br/>";
                echo "<img src='http://openweathermap.org/img/w/" . $v->weather[0]->icon . ".png'>"
                        . "</div>";
                echo "<span class='span-label'>" . round($v->temp->max) . "°C |</span>" . round($v->temp->min) . "°C<br/>";
                echo "<span class='span-label'>Morning :</span>" . $v->temp->morn . "<br/>";
                echo "<span class='span-label'>Mid Day :</span>" . $v->temp->day . "<br/>";
                echo "<span class='span-label'>Evening :</span>" . $v->temp->eve . "<br/>";
                echo "<span class='span-label'>Pressure :</span>" . $v->pressure . " hpa<br/>";
                echo "<span class='span-label'>Humidity :</span>" . $v->humidity . " %<br/>";
                echo "<span class='span-label'>Wind Speed :</span>" . $v->speed . " m/s <br/>";
                echo "<span class='span-label'>Wind Direction :</span>" . $v->deg . "°<br/>";
                echo "<span class='span-label'>Cloud Cover :</span>" . $v->clouds . " %<br/>";
                echo "<span class='span-label'>Rain :</span>" . ((property_exists($v, 'rain')) ? $v->rain ." mm": "none") . "<br/>";
                echo "</td>";
            }
            ?>
        </tr>
    </tbody>
</table>



