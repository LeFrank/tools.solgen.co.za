<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Captured Expenses</h3>
        <div id="latestExpenses">
            <h3>Five Latest Expenses</h3>
            <?php if (is_array($expenses) && !empty($expenses)) {
                ?>
                <table id="expenseSummary" class="tablesorter responsive expanded widget-zebra">
                    <thead>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Expense Type</th>
                    <th>Payment Method</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Amount</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0.0;
                        foreach ($expenses as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . $v["status"] . ": ".$v["statusMessage"]."</td>";
                            echo "<td>" . $v["expense_date"] . "</td>";
                            echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
                            echo "<td>" . $expensePaymentMethod[$v["payment_method_id"]]["description"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "<td>" . $v["location"] . "</td>";
                            echo "<td class='align-right'>" . $v["amount"] . "</td>";
                            if($v["status"] == "Success"){
                                echo "<td><a href='/expenses/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/expenses/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                            }else{
                                echo "<td>&nbsp;</td>";
                            }
                            echo "</tr>";
                            $total += $v["amount"];
                        }
                        echo "<tr class='td-total'>"
                        . "  <td class='align-left'>Latest Expenses Total</span></td>"
                        . "  <td colspan='7' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "  <td>&nbsp;</td>"
                        . "</tr>";
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No expenses captured.";
            }
            ?>
        </div>
    </div>
</div>