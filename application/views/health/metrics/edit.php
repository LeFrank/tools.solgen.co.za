<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Metrics</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/metric/update" method="POST">
            <input type="hidden" id="id" name="id" value="<?php echo $metric->id; ?>"/>
            <h3>Capture Metrics</h3>
            <div class="row expanded">
                <div class="large-3 columns">
                    <label for="metricDate">Date</label>
                    <input  type="text" id="metricDate" name="metricDate" value="<?php echo $metric->create_date; ?>" /><br/><br/>
                </div>
                <div class="large-3 columns">
                    <label for="weight">Weight *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="weight" id="weight" value="<?php echo $metric->weight; ?>" /><br />
                </div>
                <div class="large-3 columns">
                    <label for="waist">Waist *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="waist" id="waist" value="<?php echo $metric->waist; ?>"/><br />
                </div>
                <div class="large-3 columns">
                    <label for="sleep">Sleep ( Hours ) *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="sleep" id="sleep" value="<?php echo $metric->sleep; ?>"/><br />
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="note">Note</label>
                    <textarea name="note" id="note" cols="40" rows="5" ><?php echo $metric->note; ?></textarea><br/><br/>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                    <input type="submit" name="submit" value="update" class="button"/>
                </div>
            </div>
        </form>
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
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
        CKEDITOR.replace('note');
    });
</script>