<?php ?>
<div class="row ">
    <div class="large-12 columns">
        <div id="expense-period-manage-feedback" class="hidden"></div>
        <h3>Manage Budget For Period</h3>
        <div>
            <div id="manage-budget-form">
                <h3>Edit Budget</h3>
                <?php echo validation_errors(); ?>

                <?php echo form_open('expense-budget/update') ?>
                <input type="hidden" name="id" value="<?php echo $expenseBudget->id; ?>" />
                <div class="row">
                    <div class="large-4 columns">
                        <label> Filter by Period *
                        </label>
                        <select id="expensePeriod" name="expensePeriod">
                            <option value="0">Current Month</option>
                            <?php
                            foreach ($expensePeriods as $k => $v) {
                                echo "<option value='" . $v["id"] . "' " . (($expenseBudget->expense_period_id == $v["id"]) ? "selected" : "") . ">" . $v["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="large-4 columns">
                        <label for="name">Name *</label>
                        <input  type="text" name="name" value="<?php echo $expenseBudget->name; ?>"/><br/><br/>
                    </div>
                    <div class="large-4 columns">
                        <label for="total limit">Total Limit *</label>
                        <input  type="text" name="total_limit" value="<?php echo $expenseBudget->total_limit; ?>" /><br/><br/>                    
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <label for="description">Description</label>
                        <textarea name="description" cols="40" rows="5" ><?php echo $expenseBudget->description; ?></textarea><br/><br/>
                    </div>
                </div>
                <input type="submit" name="submit" value="Update" class="button"/>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="/js/expense_budget_items/manage.js"></script>
