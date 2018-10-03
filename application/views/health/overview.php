<?php
$numberOfDays = floor((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24));
//    print_r($difficultyRating);
?>
<br/>
<div class="row expanded">
    <div class="large-12 columns" >
        <h2>Statistics for the period ( <?php echo $numberOfDays; ?> days ) &nbsp;</h2>
    </div>
</div>
<div class="row expanded">
    <?php echo form_open('/health') ?>
    <div class="large-4 columns" >
        <label>
            From<input type="text" name="fromDate" id="fromDate" value="<?php echo $startDate; ?>"/>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            To<input type="text" name="toDate" id="toDate" value="<?php echo $endDate; ?>"/> 
        </label>
    </div>
    <div class="large-4 columns" style="vertical-align: central;margin-top:15px;" >
        <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
    </div>
    <?php echo form_close(); ?>
</div>

<div class="row expanded">
    <div class="large-12 columns" >
        <div class="large-4 columns" >
            <h2>Metrics</h2>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <div class="large-6 columns" >
                        <strong><?php echo number_format($healthMetricsStats->total_captured, 0, ".", ""); ?></strong>
                        <br/>Metrics captured
                    </div>
                    <div class="large-6 columns" >
                        <strong><?php echo number_format($numberOfDays / $healthMetricsStats->total_captured, 2, ".", ""); ?> days</strong>
                        <br/>Once every
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <h3>Weight</h3>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($currentMetricStat->weight, 2, ".", ""); ?> kg</strong>
                        <br/>Current
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->average_weight, 2, ".", ""); ?> kg</strong>
                        <br/>Avg
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->minimum_weight, 2, ".", ""); ?> kg</strong>
                        <br/>Min
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->maximum_weight, 2, ".", ""); ?> kg</strong>
                        <br/>Max
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <h3>Waist</h3>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($currentMetricStat->waist, 2, ".", ""); ?> cm</strong>
                        <br/>Current
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->average_waist, 2, ".", ""); ?> cm</strong>
                        <br/>Avg
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->minimum_waist, 2, ".", ""); ?> cm</strong>
                        <br/>Min
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->maximum_waist, 2, ".", ""); ?> cm</strong>
                        <br/>Max
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <h3>Sleep</h3>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($currentMetricStat->sleep, 2, ".", ""); ?> hours</strong>
                        <br/>Current
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->average_sleep, 2, ".", ""); ?> hours</strong>
                        <br/>Avg
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->minimum_sleep, 2, ".", ""); ?> hours</strong>
                        <br/>Min
                    </div>
                    <div class="large-3 columns" >
                        <strong><?php echo number_format($healthMetricsStats->maximum_sleep, 2, ".", ""); ?> hours</strong>
                        <br/>Max
                    </div>
                </div>
            </div>
        </div>
        <div class="large-8 columns" >
            <h2>&nbsp;</h2>
            <div id="waist-and-weight-over-time-period" ></div>
            <h2>&nbsp;</h2>
            <div id="sleep-over-time-period" ></div>
        </div>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns" >
        <hr/>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns" >    
        <div class="large-4 columns" >
            <h2>Exercises</h2>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <h3>General</h3>
                    <div class="large-4 columns" >
                        <strong><?php echo number_format($exerciseStats->total_captured, 0, ".", ""); ?></strong>
                        <br/>Exercises captured
                    </div>
                    <div class="large-4 columns" >
                        <strong><?php echo number_format($numberOfDays / $exerciseStats->total_captured, 2, ".", ""); ?> Days</strong>
                        <br/>Once every
                    </div>
                    <div class="large-4 columns" >
                        <strong><?php echo number_format($exerciseStats->number_of_exercise_types, 0, ".", ""); ?></strong>
                        <br/># Exercise Types
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row expanded">
                <div class="large-12 columns" >
                    <h3>Difficulty</h3>
                    <div class="large-4 columns" >
                        <strong><?php echo $difficultyRating[number_format($exerciseStats->average_difficulty, 0, ".", "")]; ?></strong>
                        <br/>Avg
                    </div>
                    <div class="large-4 columns" >
                        <strong><?php echo $difficultyRating[number_format($exerciseStats->minimum_difficulty, 0, ".", "")]; ?></strong>
                        <br/>Min
                    </div>
                    <div class="large-4 columns" >
                        <strong><?php echo $difficultyRating[number_format($exerciseStats->maximum_difficulty, 0, ".", "")]; ?></strong>
                        <br/>Max
                    </div>
                </div>
            </div>
            <hr/>

            <?php
            foreach ($exerciseByExcerciseTypeStats as $k => $v) {
                $totalDistance = "";
                if ($v["total_distance"] < 1000) {
                    $totalDistance = number_format($v["total_distance"], 0, ".", ",") . " m";
                } else {
                    $totalDistance = number_format($v["total_distance"] / 1000, 2, ". ", ",") . " Km";
                }
                ?>
                <div class="row expanded">
                    <div class="large-12 columns" >
                        <h3><?php echo $exerciseTypes[$v["exercise_type_id"]]["name"]; ?></h3>
                        <div class="large-4 columns" >
                            <strong><?php echo $v["exercise_count"]; ?></strong>
                            <br/># captured
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["total_value"], 0, ".", ","); ?></strong>
                            <br/>Total <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo $totalDistance ?></strong>
                            <br/>Total Distance
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row expanded">
                    <div class="large-12 columns" >
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["average_value"], 0, ".", ","); ?></strong>
                            <br/>Avg <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["minimum_value"], 0, ".", ","); ?></strong>
                            <br/>Min <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["maximum_value"], 0, ".", ","); ?></strong>
                            <br/>Max <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row expanded">
                    <div class="large-12 columns" >
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["average_distance"], 0, ".", ","); ?> m</strong>
                            <br/>Avg Distance
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["minimum_distance"], 0, ".", ","); ?> m</strong>
                            <br/>Min Distance
                        </div>
                        <div class="large-4 columns" >
                            <strong><?php echo number_format($v["maximum_distance"], 0, ".", ","); ?> m</strong>
                            <br/>Max Distance
                        </div>
                    </div>
                </div>
                <hr/>
                <?php
            }
            ?>
        </div>
        <div class="large-8 columns" >
            <h2>&nbsp;</h2>
            <?php
            foreach ($exerciseTypes as $k => $v) {
                echo "<div id='exercise-graph-" . $v["id"] . "-0'></div>";
                echo "<div id='exercise-graph-" . $v["id"] . "-1'></div>";
                echo "<div id='exercise-graph-" . $v["id"] . "-2'></div>";
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    var waist = <?php echo $waist; ?>;
    var weight = <?php echo $weight; ?>;
    var sleep = <?php echo $sleep; ?>;
    var sleepTarget = <?php echo $sleepTarget; ?>;
    var weightTarget = <?php echo $weightTarget; ?>;
    var waistTarget = <?php echo $waistTarget; ?>;


</script>

<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript" src="/js/third_party/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third_party/jqplot/jquery.jqplot.min.css" />

<script type="text/javascript">
    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

<?php
//            echo "<pre>";
//            print_r($exerciseGraphMetrics);
//            echo "</pre>";
foreach ($exerciseTypes as $k => $v) {
    if (!empty($exerciseGraphMetrics[$v["id"]]["measurement_value"])) {
        echo "var exercise_type_" . $v["id"] . "_0 = " . json_encode($exerciseGraphMetrics[$v["id"]]["measurement_value"]) . ";";
        echo "createplot('exercise-graph-" . $v["id"] . "-0', 'exercise_type_" . $v["id"] . "_0' , '" . $v["name"] . " - Number Of " . $v["default_measurement_name"] . "');\n";
    }
    if (!empty($exerciseGraphMetrics[$v["id"]]["difficulty"])) {
        echo "var exercise_type_" . $v["id"] . "_1 = " . json_encode($exerciseGraphMetrics[$v["id"]]["difficulty"]) . ";";
        echo "createplot('exercise-graph-" . $v["id"] . "-1', 'exercise_type_" . $v["id"] . "_1' , '" . $v["name"] . " - Difficulty');\n";
    }
    if (!empty($exerciseGraphMetrics[$v["id"]]["distance"])) {
        echo "var exercise_type_" . $v["id"] . "_2 = " . json_encode($exerciseGraphMetrics[$v["id"]]["distance"]) . ";";
        echo "createplot('exercise-graph-" . $v["id"] . "-2', 'exercise_type_" . $v["id"] . "_2' , '" . $v["name"] . " - Distance');\n";
    }
}
?>

    function createplot(id, varName, description) {
        var tttt = window[varName];
        var temp = $.jqplot(id, [tttt], {
            title: description,
            axes: {
                xaxis: {
                    renderer: $.jqplot.DateAxisRenderer,
                    tickOptions: {
                        formatString: '%b&nbsp;%#d'
                    }
                },
                yaxis: {
                    tickOptions: {
                        formatString: '%.2f'
                    }
                }
            },
            highlighter: {
                show: true,
                sizeAdjust: 7.5
            },
            cursor: {
                show: false
            },
            seriesDefaults: {
                rendererOptions: {
                    smooth: true
                }
            },

        });
    }

    // Waist and Weight measurements over period
    var plot1 = $.jqplot('waist-and-weight-over-time-period', [weight, weightTarget, waist, waistTarget], {
        title: 'Tracking Body Wellbeing Metrics Over The Time Period',
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickOptions: {
                    formatString: '%b&nbsp;%#d'
                }
            },
            yaxis: {
                tickOptions: {
                    formatString: '%.2f'
                }
            }
        },
        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {
            show: false
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true
            }
        },
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        series: [
            {label: 'Weight'},
            {label: 'Target Weight'},
            {label: 'Waist'},
            {label: 'Target Waist Measurement'}
        ]
    });

//    $('#waist-and-weight-over-time-period').bind('jqplotDataClick',
//            function(ev, seriesIndex, pointIndex, data) {
//                var url = "http://" + window.location.host + "/expenses/getExpenses/" + healthMetrics[pointIndex].id + "?keepThis=true&TB_iframe=true&width=850&height=500";
//                tb_show("Expenses", url);
//            }
//    );

    // Sleep over period
    var plot2 = $.jqplot('sleep-over-time-period', [sleep, sleepTarget], {
        title: 'Tracking Sleep Duration Over The Time Period',
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickOptions: {
                    formatString: '%b&nbsp;%#d'
                }
            },
            yaxis: {
                tickOptions: {
                    formatString: '%.2f'
                }
            }
        },
        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {
            show: false
        },
        seriesDefaults: {
            rendererOptions: {
                smooth: true
            }
        },
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        series: [
            {label: 'Recorded Sleep'},
            {label: 'Target Sleep Measurement'}
        ]
    });

//    $('#sleep-over-time-period').bind('jqplotDataClick',
//            function(ev, seriesIndex, pointIndex, data) {
//                var url = "http://" + window.location.host + "/expenses/getExpenses/" + healthMetrics[pointIndex].id + "?keepThis=true&TB_iframe=true&width=850&height=500";
//                tb_show("Expenses", url);
//            }
//    );


</script>