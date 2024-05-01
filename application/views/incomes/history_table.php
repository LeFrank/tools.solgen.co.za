
        <div id="incomeHistoryContent" class="incomeHistoryContent" >
            <div id="historyGraph">
                <h2>Income History</h2>
                Table of full data from <?php echo $startAndEndDateforMonth[0]; ?> to <?php echo $startAndEndDateforMonth[1]; ?><br/><br/>
                <?php if (is_array($incomesForPeriod) && !empty($incomesForPeriod)) {
                    ?>
                    <table id="income_history" class="tablesorter responsive">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Date</th>
                                <th>income Type</th>
                                <th>Income Asset</th>
                                <th>Description</th>
                                <th>Source</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0.0;
                            foreach ($incomesForPeriod as $k => $v) {
                                // echo "<pre>";
                                // print_r($v);
                                // echo "</pre>";
                                // exit;
                                echo "<tr>";
                                echo "<td>" . ++$k . "</td>";
                                echo "<td>" . $v["income_date"] . "</td>";
                                echo "<td>" . $incomeTypes[$v["income_type_id"]]["description"] . "</td>";
                                echo "<td>" . $incomeAssets[$v["income_asset_id"]]["description"] . "</td>";
                                echo "<td>" . $v["description"] . "</td>";
                                echo "<td>" . $v["source"] . "</td>";
                                echo "<td class='align-right'>" . $v["amount"] . "</td>";
                                echo "<td><a href='/income/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/incomes/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                                echo "</tr>";
                                $total += $v["amount"];
                            }
                            ?>
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <?php
                        echo "<tr class='td-total'>"
                        . "  <td class='align-left'>Period incomes Total</td>"
                        . "  <td colspan='6' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "</tr>";
                        ?>
                    </table>
                    <?php
                } else {
                    echo "No incomes captured.";
                }
                ?>
            </div>

        </div>
    </div>
</div>