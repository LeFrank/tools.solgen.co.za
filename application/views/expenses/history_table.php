
        <div id="expenseHistoryContent" class="expenseHistoryContent" >
            <div id="historyGraph">
                <h2>Expense History</h2>
                Table of full data from <?php echo $startAndEndDateforMonth[0]; ?> to <?php echo $startAndEndDateforMonth[1]; ?><br/><br/>
                <?php if (is_array($expensesForPeriod) && !empty($expensesForPeriod)) {
                    ?>
                    <table id="expense_history" class="tablesorter responsive">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Date</th>
                                <th>Expense Type</th>
                                <th>Payment Method</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0.0;
                            foreach ($expensesForPeriod as $k => $v) {
                                echo "<tr>";
                                echo "<td>" . ++$k . "</td>";
                                echo "<td>" . $v["expense_date"] . "</td>";
                                echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
                                echo "<td>" . $expensePaymentMethod[$v["payment_method_id"]]["description"] . "</td>";
                                echo "<td>" . $v["description"] . "</td>";
                                echo "<td>" . $v["location"] . "</td>";
                                echo "<td class='align-right'>" . $v["amount"] . "</td>";
                                echo "<td><a href='/expenses/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/expenses/delete/" . $v["id"] . "'>Delete</a></td>";
                                echo "</tr>";
                                $total += $v["amount"];
                            }
                            ?>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <?php
                        echo "<tr class='td-total'>"
                        . "  <td class='align-left'>Period Expenses Total</td>"
                        . "  <td colspan='6' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "</tr>";
                        ?>
                    </table>
                    <?php
                } else {
                    echo "No expenses captured.";
                }
                ?>
            </div>

        </div>
    </div>
</div>