<?php ?>
<div class="row">
    <div class="large-3 columns">
        <div id="agenda" class="left">
            <form name="timetable-form" action='/timetable/capture' method="POST">
                <h3>Capture An Event</h3>
                <input type="hidden" id="id" name="id" value="" />
                <label for="name">Name *</label>
                <input id="name" type="text" value="" name="name" placeholder="Party at John's/ Dentist appointment...">
                <br>
                <label for="description">Description</label>
                <textarea id="description" name="description" cols="20" rows="8"></textarea>
                <br>
                <label for="timetableCategory">Event Category *</label>
                <select name="timetableCategory" id="timetableCategory">
                    <?php
                    foreach ($timetableCategories as $k => $v) {
                        echo '<option value="' . $v["id"] . '">' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <label for="allDayEvent">All Day Event?</label>
                <input  type="checkbox" id="allDayEvent" name="allDayEvent" value="1" />
                <br/>
                <label for="startDate">Start Date</label>
                <input  type="text" id="startDate" name="startDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                <br/>
                <label for="endDate">End Date</label>
                <input  type="text" id="endDate" name="endDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                <br/>
                <label for="location">Repetition</label>
                <select name="timetableRepetition" id="timetableRepetition" >
                    <option value="0">None</option>
                    <?php
                    foreach ($eventRepetition as $k => $v) {
                        echo '<option value="' . $v->id . '">' . $v->name . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <label for="numberOfRepeats" id="numRepeatsLabel" >Amount of Repeats</label>
                <input step="1" type="number" max="100" id="numberOfRepeats" name="numberOfRepeats" placeholder="0"  disabled></input>
                &nbsp;<span id="repeatDescriptor"></span>
                <br/>
                <label for="location">Location</label>
                <select name="timetableLocation" id="timetableLocation" >
                    <option value="0">None</option>
                    <?php
                    foreach ($locations as $k => $v) {
                        echo '<option value="' . $v->id . '">' . $v->name . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <label for="or"></label>
                <strong>or</strong>
                <br/>
                <label for="locationText"></label>
                <input type="text" name="locationText" id="locationText" value="" placeholder="55 John way, Goodwood, Cape Town, South Africa">
                <br/>
                <label for="expenseType">Expense Type</label>
                <select name="timetableExpenseType" id="timetableExpenseType">
                    <option value="0">none</option>
                    <?php
                    foreach ($expenseTypes as $k => $v) {
                        echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
                    }
                    ?>
                </select>
                <br/>
                <input type='submit' value='Submit'></input>
                &nbsp;&nbsp;
                <a href="#" id="clearForm" class="hidden">New</a>
                &nbsp;&nbsp;
                <a href="#" id="delete" class="hidden" >Delete</a>
            </form>
        </div>
    </div>
    <div class="large-9 columns">
        <div id='calendar' class="calendar-full"></div>
    </div>
    <script type='text/javascript'>
        var expenseTypes = <?php echo json_encode($expenseTypes); ?>;
        var eventsArray = <?php echo $events; ?>;
    </script>
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
    <link rel="stylesheet" href="/css/third_party/qtip/jquery.qtip.min.css">
    <script src="/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
    <script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
    <script src="/js/third_party/qtip/jquery.qtip.min.js"></script>
    <script src='/js/third_party/FullCalendar/moment.min.js' type='text/javascript'></script>
    <script src='/js/third_party/FullCalendar/fullcalendar.min.js' type='text/javascript'></script>
    <script src='/js/timetable/timetable.js' type='text/javascript'></script>