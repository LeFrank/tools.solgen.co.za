<?php ?>
<div class="row" id="notes-stats-content">
    <div class="large-12 columns">
        <h3>Notes Statistics for the period ( <?php echo floor((strtotime($startAndEndDateforMonth[1]) - strtotime($startAndEndDateforMonth[0])) / (60 * 60 * 24)) + 1; ?> days ) &nbsp;</h3>
        <div class="row">
            <div class="large-6 columns">
                <label> Date From
                    <input type="text" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
                </label>
            </div>
            <div class="large-6 columns">
                <label>
                    Date To<input type="text" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns" >
                <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="large-12 columns" id="statsContent" >
                <label>Total Notes:</label>
                <?php echo $totalNotes; ?>
                <br/>
                <label>Average Notes Per Day:</label>
                <?php echo $averageNotesPerPeriod; ?>
                <br/>
                <h3>Hour of the day when notes were created during the selected period</h3>
                <div id="notes-per-hour-over-period" ></div>
                </br>
                <!-- <ul>
                    <li><span style="background-color:rgb(255, 160, 122)"><s>Number of notes</s></span></li>
                    <li><span style="background-color:rgb(255, 160, 122)"><s>Average number of notes per period</s></span></li>
                    <li><span style="background-color:rgb(255, 160, 122)"><s>what time of day most notes are created</s></span></li>
                    <li><span style="background-color:rgb(255, 160, 122)"><s>what time of day most notes are updated</s></span></li>
                    <li><span style="background-color:rgb(255, 160, 122)">average number of&nbsp;updates per note.</span></li>
                    <li><span style="background-color:rgb(255, 160, 122)">number of searches</span></li>
                </ul> -->

            </div>
        </div>
    </div>  
</div>
<script type="text/javascript">
    // for the hour of day graph
    hours = ['00h', '01h', '02h', '03h', '04h', '05h',
        '06h', '07h', '08h', '09h', '10h', '11h',
        '12h', '13h', '14h', '15h', '16h', '17h',
        '18h', '19h', '20h', '21h', '22h', '23h'];
    var amount = [
<?php
$countHourAmount = 0;
foreach ($hourOfDay as $k => $v) {
    echo $v["value"] . ((sizeOf($hourOfDay) != $countHourAmount) ? ',' : '');
    $countHourAmount++;
}
?>
    ];

    var noteCount = [<?php
$countHourCount = 0;
foreach ($hourOfDay as $k => $v) {
    echo $v["noteCount"] . ((sizeOf($hourOfDay) != $countHourCount) ? ',' : '');
    $countHourCount++;
}
?>
    ];

</script>
<script type="text/javascript" src="/js/third_party/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third_party/jqplot/jquery.jqplot.min.css" />
<script type="text/javascript" src="/js/notes/stats.js" />
