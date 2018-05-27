<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Metrics</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/metric/capture" method="POST">
            <h3>Capture Metrics</h3>
            <div class="row expanded">
                <div class="large-3 columns">
                    <label for="metricDate">Date</label>
                    <input  type="text" id="metricDate" name="metricDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
                </div>
                <div class="large-3 columns">
                    <label for="weight">Weight *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="weight" id="weight" placeholder="0.00" /><br />
                </div>
                <div class="large-3 columns">
                    <label for="waist">Waist *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="waist" id="waist" placeholder="0.00"/><br />
                </div>
                <div class="large-3 columns">
                    <label for="sleep">Sleep ( Hours ) *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="sleep" id="sleep" placeholder="0.00"/><br />
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" cols="40" rows="5" placeholder="Anything significant happened, or something that could have impact on your goals positive or negative."></textarea><br/><br/>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                    <input type="submit" name="submit" value="Record" class="button"/>
                </div>
            </div>
        </form>
    </div>
</div>
<hr/>
<div class="row expanded" >
    <div class="large-12 columns" >
        Metrics from <?php echo $startAndEndDate[0]; ?> to <?php echo $startAndEndDate[1]; ?><br/><br/>
            <?php if (is_array($healthMetrics) && !empty($healthMetrics)) {
                ?>
                <table id="health_metrics_history" class="tablesorter responsive">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weight</th>
                            <th>Waist</th>
                            <th>Sleep</th>
                            <th>note</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($healthMetrics as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . date_format(date_create($v["measurement_date"]), "l, d F Y @ H:i") . "</td>";
                            echo "<td>" . $v["weight"] . "</td>";
                            echo "<td>" . $v["waist"] . "</td>";
                            echo "<td>" . $v["sleep"] . "</td>";
                            echo "<td>" . $v["note"] . "</td>";
                            echo "<td><a href='/health/metric/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/health/metric/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No metrics captured yet.";
            }
            ?>
    </div>
</div>
    
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/location/autocomplete.js"></script>
<script type="text/javascript">
    $(function () {
        $("#metricDate").datetimepicker();
        CKEDITOR.replace('note');
    });
</script>