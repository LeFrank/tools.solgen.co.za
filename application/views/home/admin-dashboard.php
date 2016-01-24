<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1>
    Admin Dashboard.
</h1>
<h3>
    User Stats
</h3>
<label>User Count:
    <?php echo $registered_users["user_count"]; ?> </label>
<br/>
<h3>
    Next 7 days calendar events, starting with the current days events. est. 3 hours
</h3>
<?php
echo $eventsView;
?>
<br/>
<h3>
    Current budget position
</h3>
<?php
echo $eventsBudgetItems;
?>

