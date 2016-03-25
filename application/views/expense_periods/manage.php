<?php ?>
<div class="row ">
    <div class="large-12 columns">
        <div id="expense-period-manage-feedback" class="hidden"></div>
        <h3>Manage Expense Periods</h3>
        <div>
            <p>My Expense Periods</p>
            <?php
            if (!empty($expensePeriods)) {
                ?>
                <table class="tablesorter full-width">
                    <thead>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Create Date</th>
                    <th>Active</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php 
                            
                            foreach ($expensePeriods as $k => $v) { ?>
                            <tr>    
                                <td><?php echo $v["name"]; ?></td>
                                <td><?php echo $v["description"]; ?></td>
                                <td><?php echo $v["start_date"]; ?></td>
                                <td><?php echo $v["end_date"]; ?></td>
                                <td><?php echo $v["create_date"]; ?></td>
                                <td><?php echo (($v["active"] == 1) ?"True": "False" ); ?></td>
                                <td>
                                    <a href="/expense-periods/edit/<?php echo $v["id"]; ?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <a href="/expense-periods/delete/<?php echo $v["id"]; ?>">delete</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p>No expense periods exist.</p>";
            }
            ?>
        </div>

        <div id="manage-expense-period-form">
            <h3>Create Expense Period</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('expense-periods/capture') ?>
            <label for="name">Name *</label>
            <input type="text" name="name" autofocus placeholder="June - July" /><br />
            <label for="description">Description *</label>
            <input type="text" name="description" placeholder="Trip to spain is this period"/><br />
            <div class="row">
                <div class="large-6 columns">
                    <label>Start Date *
                        <input  type="text" id="startDate" name="startDate" value="" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                    </label>
                </div>
                <div class="large-6 columns">
                    <label>
                        End Date *<input  type="text" id="endDate" name="endDate" value="" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-2 columns">
                    <label>Active
                        <select name="active" id="active-period">
                            <option value="1">True</option>
                            <option value="0" selected>False</option>
                        </select>
                    </label>
                </div>
            </div>            
            <div class="row">
                <div class="large-12 columns">
                    <br/>
                    <input type="submit" name="submit" value="Create Expense Period" class="button"/>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#startDate").datetimepicker();
        $("#endDate").datetimepicker();
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
