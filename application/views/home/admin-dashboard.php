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
<?php echo $registered_users;?> </label>
<ul>
    <li>
        Show the next 7 days calendar events, starting with the current days events. est. 3 hours
        <?php 
            echo $eventsView;
        ?>
        <br/>
    </li>
    <li>
        Show the weather for each days events. If the event is linked to a location get the weather for the location for the day. est 6 hours
    </li>
    <li>
        Show notes marked as top of mind in a revolving note gallery. est. 1 hour
    </li>
    <li>
        Current budget position est. 2 hours
        <?php 
            echo $eventsBudgetItems;
        ?>
    </li>
</ul>

