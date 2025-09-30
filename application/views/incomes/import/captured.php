<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Captured Incomes</h3>
        <?php if (is_array($incomes) && !empty($incomes)) {
            ?>
            <table id="incomeSummary" class="tablesorter responsive expanded widget-zebra">
                <thead>
                <!-- <th>Status</th> -->
                <th>Date</th>
                <th>Income Type</th>
                <th>Income Assets</th>
                <th>Description</th>
                <th>Location</th>
                <th>Amount</th>
                <th>Actions</th>
                </thead>
                <tbody>
                    <?php
                    $total = 0.0;
                    foreach ($incomes as $k => $v) {
                        echo "<tr>";
                        // echo "<td>" . $v["status"] . ": " . $v["statusMessage"] . "</td>";
                        echo "<td>" . $v["income_date"] . "</td>";
                        echo "<td>" . $incomeTypes[$v["income_type_id"]]["description"] . "</td>";
                        echo "<td>" . $incomeAssets[$v["income_asset_id"]]["description"] . "</td>";
                        echo "<td>" . $v["description"] . "</td>";
                        echo "<td>" . $v["location"] . "</td>";
                        echo "<td class='align-right'>" . $v["amount"] . "</td>";
                        // if ($v["status"] == "Success") {
                            echo "<td><a href='/incomes/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/incomes/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                        // } else {
                        //     echo "<td>&nbsp;</td>";
                        // }
                        echo "</tr>";
                        $total += $v["amount"];
                    }
                    echo "<tr class='td-total'>"
                    . "  <td class='align-left'>Latest Incomes Total</span></td>"
                    . "  <td colspan='7' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                    . "  <td>&nbsp;</td>"
                    . "</tr>";
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "No incomes captured.";
        }
        ?>
    </div>
</div>