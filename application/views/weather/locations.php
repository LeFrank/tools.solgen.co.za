<?php
if (empty($myWeather)) {
    
} else {
    ?>    
    <div>
        <div id="weather-locations" style="">
            <h3>View weather for my locations.</h3>
            <?php
            if (!empty($locations)) {
                foreach ($locations as $k => $v) {
                    echo '<span class="weather-location-label">' . $v->name . "</span>";
                    echo ': <a href="#" onclick="viewTodaysWeatherFor(' . $v->id . ');" >Today</a>';
                    echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onclick="viewSevenDayForecastFor(' . $v->id . ');" >7 day forecast</a>';
                    echo "<br/>";
                }
            } else {
                
            }
            ?>
        </div>
        <div id="weatherLocationDetails" class="hidden">

        </div>
    </div>
    <?php
}
?>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
<script type="text/javascript" src="/js/weather/weather.js" ></script>
<script type="text/javascript">
    var weatherSetting = <?php echo json_encode($weatherSettings);?>;
    var measure = <?php echo json_encode($measure);?>;
</script>