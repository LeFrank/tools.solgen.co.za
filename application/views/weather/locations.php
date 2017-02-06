<?php
if (empty($myWeather)) {
    
} else {
    ?>    
    <div class="row expanded">
        <div class="large-12 columns">
            <div>
                <div class="row expanded">
                    <div class="large-3 columns">
                        <div id="weather-locations" style="">
                            <h3>View weather for my locations.</h3>
                            <?php
                            if (!empty($locations)) {
                                foreach ($locations as $k => $v) {
                                    echo '<span class="weather-location-label">' . $v->name . "</span>";
                                    echo ': <a href="#weatherLocationDetailsAnchor" onclick="viewTodaysWeatherFor(' . $v->id . ');" >Today</a>';
                                    echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onclick="viewSevenDayForecastFor(' . $v->id . ');" >7 day forecast</a>';
                                    echo "<br/>";
                                }
                            } else {
                                
                            }
                            ?>
                        </div>
                    </div>
                    <div class="large-9 columns">
                        <a name="weatherLocationDetailsAnchor" />
                        <div id="weatherLocationDetails" class="hidden">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
<script type="text/javascript" src="/js/weather/weather.js" ></script>
<script type="text/javascript">
    var weatherSetting = <?php echo json_encode($weatherSettings); ?>;
    var measure = <?php echo json_encode($measure); ?>;
</script>