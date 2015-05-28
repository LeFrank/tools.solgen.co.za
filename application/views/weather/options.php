<?php
?>
<h3>Weather Options</h3>
<form action="">
    <span class="label">Unit of Measurement</span>
    <input type="radio" name="measurement" value="metric" <?php echo ($weatherSetting->measurement == "metric")?"checked":"";?>>Metric ( <?php echo $measure["metric"];?> )&nbsp;&nbsp;|&nbsp;&nbsp;
<input type="radio" name="measurement" value="imperial"<?php echo ($weatherSetting->measurement == "imperial")?"checked":"";?>>Imperial ( <?php echo $measure["imperial"];?> )
&nbsp;&nbsp;
<span id="measurement-stat"></span><br/>
</form>


<script type="text/javascript" src="/js/weather/options.js" ></script>