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
<script type='text/javascript'>
    var expenseTypes = <?php echo json_encode($expenseTypes); ?>;
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
<script src='/js/timetable/search.js' type='text/javascript'></script>
<br/>
<h3>
    Current budget position
</h3>
<?php
echo $eventsBudgetItems;
?>

