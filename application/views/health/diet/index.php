<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Diet Tracker</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/diet/capture" method="POST">
            <h3>Log Intake</h3>
            <div class="row expanded">
                <div class="large-2 columns">
                    <label for="consumptionDate">Consumption Date</label>
                    <input  type="text" id="consumptionDate" name="consumptionDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
                </div>
                <div class="large-2 columns">
                    <label for="intakeType">Intake Type</label>
                    <select name="intakeType" id="intakeType" >
                        <option value="0">None</option>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="measurement_value" id="measurement_value_label">Measurement Name</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="measurement_value" id="measurement_value" placeholder="0.00"/><br />
                </div>
                <div class="large-3 columns">
                    <label for="deliciousness">Deliciousness</label>
                    <select name="deliciousness" id="deliciousness" >
                        <option value="0">0 - Nausea Inducing</option>
                        <option value="1">1 - Disgusting</option>
                        <option value="2">2 - Incorrectly Prepared. ( Raw / Overcooked/ Off / Unripe / Overripe )</option>
                        <option value="3">3 - Bad</option>
                        <option value="4">4 - Bland ( Unappetizing, but palatable )</option>
                        <option value="5">5 - OK, nice to eat, but not really memorable.</option>
                        <option value="6">6 - Good. Mom/Dad's cooking</option>
                        <option value="7">7 - Delicious.</option>
                        <option value="8">8 - Speciality.</option>
                        <option value="9">9 - Legit Gourmet</option>
                        <option value="10">10 - MMMMMmmmmmm, Your Palate Will Never Forget It. </option>
                    </select>
                </div>
                <div class="large-3 columns">
                    <label for="healthiness">Healthiness Rating</label>
<!--                    <input type="number" min="0" step="1" max="10" name="difficulty" id="difficulty" placeholder="5"/><br />-->
                    <select name="healthiness" id="healthiness" >
                        <option value="0">0 - Poison</option>
                        <option value="1">1 - Toxic</option>
                        <option value="2">2 - Bad Short Term</option>
                        <option value="3">3 - Bad Medium Term</option>
                        <option value="4">4 - Bad Long Term</option>
                        <option value="5">5 - OK</option>
                        <option value="6">6 - Balanced</option>
                        <option value="7">7 - Good Variety</option>
                        <option value="8">8 - Good Portion Size and Preparation</option>
                        <option value="9">9 - Best Ingredients and High in Vitamins and Minerals</option>
                        <option value="10">10 - Clean, Nutritious </option>
                    </select>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="note">Description</label>
                    <textarea name="description" id="description" cols="40" rows="5" placeholder="Anything significant happened, or something that could have impact on your goals positive or negative."></textarea><br/><br/>
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
<div class="row expanded">
    <?php echo form_open('/health/exercise/tracker') ?>
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
<div class="row expanded" >
    <div class="large-12 columns" >
        <?php 
//        echo "<pre>";
//        print_r($exerciseTypes);
//        echo "</pre>";
        if (is_array($items) && !empty($items)) {
            ?>
            <table id="health_diet_items_history" class="tablesorter responsive">
                <thead>
                    <tr>
                        <th>Intake Date</th>
                        <th>Intake Type</th>
                        <th>Measurement</th>
                        <th>Deliciousness</th>
                        <th>Healthiness</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($items as $k => $v) {
                        echo "<tr>";
                        echo "<td>" . date_format(date_create($v["create_date"]), "l, d F Y @ H:i") . "</td>";
                        echo "<td>" . $v["intake_type"] . "</td>";
                        echo "<td>" . $v["measurement"] . "</td>";
                        echo "<td>" . $v["deliciousness"] . "</td>";
                        echo "<td>" . $v["healthiness"] . "</td>";
                        echo "<td>" . $v["description"] . "</td>";
                        echo "<td><a href='/health/diet/edit/" . $v["id"] . "'>Edit</a>"
                                . "&nbsp;&nbsp;|&nbsp;&nbsp;"
                                . "<a href='/health/diet/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a>"
                           . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "No Diet items captured yet.";
        }
        ?>
    </div>
</div>

<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/health/diet/index.js"></script>