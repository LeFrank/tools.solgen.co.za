<?php ?>
<input type="button" id="add-event" value="Add Event" ></input>
<div id='calendar' class="calendar-full"></div>
<div id="agenda" class="left">
    <form name="timetable-form">
        <h3>Capture An Event</h3>
        <label for="name">Name *</label>
        <input id="name" type="text" value="" name="name" placeholder="Party at John's/ Dentist appointment...">
        <br>
        <label for="description">Description</label>
        <input id="description" type="text" value="" name="description" placeholder="John's birthday party, remember to get a gift!">
        <br>
        <label for="timetableCategory">Event Category *</label>
        <select name="timetableCategory">
            <?php
            foreach ($timetableCategories as $k => $v) {
                echo '<option value="' . $v["id"] . '">' . $v["name"] . '</option>';
            }
            ?>
        </select>
        <br/>
        <label for="startDate">Start Date</label>
        <input  type="text" id="startDate" name="startDate" placeholder="<?php echo date('Y/m/d H:i:s');?>" />
        <br/>
        <label for="endDate">End Date</label>
        <input  type="text" id="endDate" name="endDate" placeholder="<?php echo date('Y/m/d H:i:s');?>" /><br/><br/>
        <br/>
        <label for="location">Location</label>
        <br/>
    </form>
</div>
<script type='text/javascript'>
    var expenseTypes = <?php echo json_encode($expenseTypes); ?>;
</script> 