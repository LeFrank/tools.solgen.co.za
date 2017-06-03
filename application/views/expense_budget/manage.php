<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="expense-period-manage-feedback" class="hidden"></div>
        <h3>Manage Budget For Period</h3>
        <div>
            <p>My Budgets</p>

            <?php
            if (!empty($expenseBudgets)) {
                ?>
                <table id="expense_history" class="tablesorter">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Expense Period</th>
                            <th>Description</th>
                            <th>Total Limit</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($expenseBudgets as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . $v["name"] . "</td>";
                            echo "<td>" . $expensePeriods[$v["expense_period_id"]]["name"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "<td>" . $v["total_limit"] . "</td>";
                            echo "<td>" . $v["create_date"] . "</td>";
                            echo "<td><a href='/expense-budget-items/items/" . $v["id"] . "'>Budget Limits     </a>"
                            . "<a href='/expense-budget/edit/" . $v["id"] . "'>Edit</a>"
                            . "&nbsp;&nbsp;|&nbsp;&nbsp;"
                            . "<a href='/expense-budget/delete/" . $v["id"] . "' onclick=\"return confirm_delete()\">Delete</a>";
                            if(!$expensePeriods[$v["expense_period_id"]]["active"]){
                                echo "<br/>";
                                echo "<a href='/expense-budget/post-analysis/" . $v["id"] . "'>Post Analysis</a>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                ?>
                <p>No Budgets Created</p>
                <?php
            }
            ?>
        </div>

        <div id="manage-budget-form">
            <h3>Capture Budget</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('expense-budget/capture') ?>
            <div class="row expanded">
                <div class="large-4 columns">
                    <label> Filter by Period *
                    </label>
                    <select id="expensePeriod" name="expensePeriod">
                        <option value="0">Current Month</option>
                        <?php
                        foreach ($expensePeriods as $k => $v) {
                            echo "<option value='" . $v["id"] . "'>" . $v["name"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="large-4 columns">
                    <label for="name">Name *</label>
                    <input  type="text" name="name" placeholder="Major goals for this period."/><br/><br/>
                </div>
                <div class="large-4 columns">
                    <label for="total limit">Total Limit *</label>
                    <input  type="text" name="total_limit" placeholder="1000000.00"/><br/><br/>                    
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="description">Description</label>
                    <textarea name="description" cols="40" rows="5" placeholder="What was special about it, or a description of the expense."></textarea><br/><br/>
                </div>
            </div>
            <input type="submit" name="submit" value="Record" class="button"/>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expense_budget_items/manage.js"></script>
