<?php ?>
<div class="row expanded">
    <div class="large-3 columns">
        <div id="agenda" class="left">
            <form name="timetable-form" action='/timetable/capture' method="POST">
                <h3>Capture An Event</h3>
                <input type="hidden" id="id" name="id" value="" />
                <input type="hidden" id="fcViewState" name="fcViewState" value="<?php echo (!empty($fcViewState))?$fcViewState:''; ?>" />
                <label for="name">Name *</label>
                <input id="name" type="text" value="" name="name" placeholder="Party at John's/ Dentist appointment..." autofocus />
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
<!--                <label for="location">Location</label>
                <select name="timetableLocation" id="timetableLocation" >
                    <option value="0">None</option>
                    <?php
//                    foreach ($locations as $k => $v) {
//                        echo '<option value="' . $v->id . '">' . $v->name . '</option>';
//                    }
                    ?>
                </select>-->
                <label for="location">Location</label>
                <input  type="text" id="location" name="location" placeholder="Where was the expense made?"/>
                <input  type="hidden" id="locationId" name="locationId" value="0"/><br/><br/>
                <br/>
<!--                <label for="or"></label>
                <strong>or</strong>
                <br/>
                <label for="locationText"></label>
                <input type="text" name="locationText" id="locationText" value="" placeholder="55 John way, Goodwood, Cape Town, South Africa">
                <br/>-->
                <label for="expenseType">Expense Type</label>
                <select name="timetableExpenseType" id="timetableExpenseType">
                    <option value="0">none</option>
                    <?php
                    foreach ($expenseTypes as $k => $v) {
                        echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
                    }
                    ?>
                </select>
                <br/><br/>
                <input type='submit' value='Submit' class="button"></input>
                &nbsp;&nbsp;
                <a href="#" id="clearForm" class="button secondary hidden">New</a>
                &nbsp;&nbsp;
                <a href="#" id="delete" class="button secondary hidden" onclick="return confirm_delete()" >Delete</a>
            </form>
        </div>
    </div>
    <div class="large-9 columns">
        <div id='calendar' class="calendar-full"></div>
    </div>
    <script type='text/javascript'>
        var expenseTypes = <?php echo json_encode($expenseTypes); ?>;
        var timetableCategories = <?php echo json_encode($timetableCategories);?>;
        var eventsArray = <?php echo $events; ?>;
        <?php if(isset($currentEvent)){
            echo "var currentEvent = " . $currentEvent .";";
        } ?>
        var currentDateRange = {"startDate" : "<?php echo $startAndEndDateforMonth[0]; ?>" , "endDate": "<?php echo $startAndEndDateforMonth[1]; ?>"};
    </script>
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
    <link rel="stylesheet" href="/css/third_party/qtip/jquery.qtip.min.css">
    <script src="/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
    <script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
    <script src="/js/third_party/qtip/jquery.qtip.min.js"></script>
    <script src='/js/third_party/FullCalendar/moment.min.js' type='text/javascript'></script>
    <script src='/js/third_party/FullCalendar/fullcalendar.min.js' type='text/javascript'></script>
    <script src="/js/third_party/ckeditor/ckeditor.js"></script>
    <script src='/js/timetable/timetable.js' type='text/javascript'></script>
    <script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
    <script src="/js/location/autocomplete.js"></script>