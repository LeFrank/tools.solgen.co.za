<?php if (is_array($wishlistItemsForPeriod) && !empty($wishlistItemsForPeriod)) {
    ?>
    <table id="wishlistItems" class="tablesorter responsive">
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
        <?php 
        if(!isset($includeActions) || $includeActions){?>
        <th>Actions</th>
        <?php }?>
    </thead>
    <tbody>
        <?php
        $total = 0.0;
        foreach ($wishlistItemsForPeriod as $k => $v) {
            echo "<tr>";
            echo "<td>" . ++$k . "</td>";
            echo "<td>" . $v["name"] . "</td>";
            echo "<td>" . $v["description"] . "</td>";
            echo "<td>" . $v["reason"] . "</td>";
            echo "<td>" . $v["priority"] . " - " . $priorities[$v["priority"]] . "</td>";
            echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
            echo "<td>" . $v["target_date"] . "</td>";
            echo "<td>" . $v["status"] . " - " . $statuses[$v["status"]] . "</td>";
            echo "<td class='align-right'>" . $v["cost"] . "</td>";
            if(!isset($includeActions) ||$includeActions){
                echo "<td><a href='/wishlist/edit/" . $v["id"] . "'>Edit</a>";
                echo " | ";
                echo "      <a href='/wishlist/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a>";
                echo "</td>";
            }
            echo "</tr>";
            $total += $v["cost"];
        }
        ?>
    </tbody>
    </table>
    <table class="tablesorter responsive">
        <?php
        echo "<tr class='td-total'>"
        . "  <td class='align-left'>Latest Wishlist Items Total</span></td>"
        . "  <td colspan='7' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
        . "  <td >&nbsp;</td>"
        . "</tr>";
        ?>   
    </table>
    <?php
} else {
    echo "No wishlist items captured.";
}
?>