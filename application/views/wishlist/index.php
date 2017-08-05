<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Recent Wishlist Items</h2>
        <div id="latestItems">
            <h3>Five Latest Items</h3>
            <?php if (is_array($wishlistItems) && !empty($wishlistItems)) {
                ?>
                <table id="wishlistItemSummary" class="tablesorter full-width">
                    <thead>
                    <th/>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Reason</th>
                    <th>priority</th>
                    <th>Expense Type</th>
                    <th>Target Date</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0.0;
                        foreach ($wishlistItems as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . ++$k . "</td>";
                            echo "<td>" . $v["name"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "<td>" . $v["reason"] . "</td>";
                            echo "<td>" . $priorities[$v["priority"]] . "</td>";
                            echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
                            echo "<td>" . $v["target_date"] . "</td>";
                            echo "<td>" . $statuses[$v["status"]] . "</td>";
                            echo "<td class='align-right'>" . $v["cost"] . "</td>";
                            echo "<td><a href='/expense-wishlist/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;"
                            . "<a href='/expense-wishlist/delete/" . $v["id"] . "' onclick='return confirm_delete()' >Delete</a></td>";
                            echo "</tr>";
                            $total += $v["cost"];
                        }
                        echo "<tr class='td-total'>"
                        . "  <td class='align-left'>Latest Wishlist Items Total</span></td>"
                        . "  <td colspan='7' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "  <td >&nbsp;</td>"
                        . "</tr>";
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No wishlist items captured.";
            }
            ?>
        </div>
        <br/>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="captureExpenses">
            <h3>Capture Wishlist Item</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('expense-wishlist/capture') ?>
            <div class="row expanded">
                <div class="large-2 columns">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" placeholder="Awesome new thing" autofocus /><br />
                </div>
                <div class="large-2 columns">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority"> 
                        <?php foreach ($priorities as $k => $v) { ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="expenseType">Expense Type</label>
                    <select name="expenseType" id="expenseType"> 
                        <?php
                        foreach ($expenseTypes as $k => $v) {
                            echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="cost">Estimated Cost</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="cost" id="cost" placeholder="0.00" /><br />
                </div>
                <div class="large-2 columns">
                    <label for="targetDate">Target Date</label>
                    <input  type="text" id="targetDate" name="targetDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                </div>
                <div class="large-2 columns">
                    <label for="status">Status</label>
                    <select name="status" id="status"> 
                        <?php foreach ($statuses as $k => $v) { ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php } ?>    
                    </select>
                </div>
                <div class="large-5 columns">
                </div>
            </div>
            <div class="row expanded"><div class="large-12 columns">&nbsp;</div></div>
            <div class="row expanded">
                <div class="large-6 columns">
                    <label for="description">Item Description</label>
                    <textarea name="description" id="description" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."></textarea>
                </div>
                <div class="large-6 columns">
                    <label for="reason">Reason/Desire/Need/Motivation</label>
                    <textarea name="reason" id="reason" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."></textarea>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                </div>
            </div>
            <input type="submit" name="submit" value="Record" class="button"/>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/wishlist/history.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#targetDate").datetimepicker();
        CKEDITOR.replace('description');
        CKEDITOR.replace('reason');
    });
</script>