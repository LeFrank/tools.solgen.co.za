<?php ?>
<form name="timetable-form" action='/timetable/capture' method="POST">
    <div class="row">
        <div class="large-12 columns">
            <h3>Update An Event</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-4 columns">
            <input type="hidden" id="id" name="id" value="<?php echo $event->id; ?>" />
            <label for="name">Name *</label>
            <input id="name" type="text" value="<?php echo $event->name; ?>" name="name" placeholder="Party at John's/ Dentist appointment..." autofocus />
            <br>
            <label for="timetableCategory">Event Category *</label>
            <select name="timetableCategory" id="timetableCategory" autocomplete="off">
                <?php
                foreach ($timetableCategories as $k => $v) {
                    echo '<option value="' . $v["id"] . '" '. (($v["id"] == $event->tt_category_id )? "selected":"")   .' >' . $v["name"] . '</option>';
                }
                ?>
            </select>
            <br/>
            <label for="allDayEvent">All Day Event?</label>
            <input  type="checkbox" id="allDayEvent" name="allDayEvent" value="<?php echo $event->all_day_event; ?>" />
            <br/>
            <label for="startDate">Start Date</label>
            <input  type="text" id="startDate" name="startDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" value="<?php echo $event->start_date; ?>"/>
            <br/>
            <label for="endDate">End Date</label>
            <input  type="text" id="endDate" name="endDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>"  value="<?php echo $event->end_date; ?>"/>
            <br/>
            <label for="location">Repetition</label>
            <select name="timetableRepetition" id="timetableRepetition" autocomplete="off" >
                <option value="0"  <?php echo (("0" == $event->repition_id )? "selected":"");   ?> >None</option>
                <?php
                foreach ($eventRepetition as $k => $v) {
                    echo '<option value="' . $v->id . '" '.(($v->id == $event->repition_id )? "selected":"").'  >' . $v->name . '</option>';
                }
                ?>
            </select>
            <br/>
            <label for="numberOfRepeats" id="numRepeatsLabel" >Amount of Repeats</label>
            <input step="1" type="number" max="100" id="numberOfRepeats" name="numberOfRepeats" placeholder="0"  disabled></input>
            &nbsp;<span id="repeatDescriptor"></span>
            <br/>
            <label for="location">Location</label>
            <select name="timetableLocation" id="timetableLocation" autocomplete="off">
                <option value="0" <?php echo (("0" == $event->location_id )? "selected":"");   ?> >None</option>
                <?php
                foreach ($locations as $k => $v) {
                    echo '<option value="' . $v->id . '" '.(($v->id == $event->location_id )? "selected":"").' >' . $v->name . '</option>';
                }
                ?>
            </select>
            <br/>
            <label for="or"></label>
            <strong>or</strong>
            <br/>
            <label for="locationText"></label>
            <input type="text" name="locationText" id="locationText" value="<?php echo $event->location_text;?>" placeholder="55 John way, Goodwood, Cape Town, South Africa">
            <br/>
            <label for="expenseType">Expense Type</label>
            <select name="timetableExpenseType" id="timetableExpenseType" autocomplete="off">
                <option value="0" <?php echo (("0" == $event->expense_type_id )? "selected":"");?> >none</option>
                <?php
                foreach ($expenseTypes as $k => $v) {
                    echo '<option value="' . $v["id"] . '" '. (($v["id"] == $event->expense_type_id )? "selected":"") .' >' . $v["description"] . '</option>';
                }
                ?>
            </select>
            <br/><br/>
            <input type='submit' value='Submit' class="button"></input>
            &nbsp;&nbsp;
            <a href="#" id="clearForm" class="button secondary hidden">New</a>
            &nbsp;&nbsp;
            <a href="#" id="delete" class="button secondary hidden" >Delete</a>
        </div>
        <div class="large-8 columns">
            <label for="description">Description</label>
            <textarea id="description" name="description" cols="20" rows="8"><?php echo $event->description; ?></textarea>
            <br>
        </div>
    </div>
</form>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<script src='/js/timetable/edit.js' type='text/javascript'></script>