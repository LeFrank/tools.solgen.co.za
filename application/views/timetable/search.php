<?php ?>
<div class="row">
    <div class="large-4 columns">
        <div id="agenda" class="left">
            <form name="timetable-search-form" id="timetable-search-form" action='/timetable/search' method="POST">
                <h3>Search For An Event</h3>
                <input type="hidden" id="id" name="id" value="" />
                <label for="name">Name</label>
                <input id="name" type="text" value="" name="name" placeholder="Party at John's/ Dentist appointment...">
                <br>
                <label for="description">Description</label>
                <textarea id="description" name="description" cols="20" rows="8"></textarea>
                <br>
                <label for="timetableCategory">Event Category *</label>
                <select name="timetableCategory" id="timetableCategory">
                    <option value="" >none</option>
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
                <label for="location">Location TODO: make autocomplete</label>
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
                <br/><br/>
                <input type='button' value='Search' class="button" id="search-timetable"></input>
            </form>
        </div>
    </div>
    <div class="large-8 columns panel" id="search-entries">
        Search results go here
    </div>
</div>
<script type='text/javascript'>
    var expenseTypes = <?php echo json_encode($expenseTypes); ?>;
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.formatDateTime.min.js" ></script>
<script src='/js/timetable/search.js' type='text/javascript'></script>