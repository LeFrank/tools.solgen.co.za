
<?php ?>
<div class="row expanded">
    <div class="large-12 columns" >
        <h1>Tasks Dashboard             <span id="searchExpand"><img src="/images/third_party/icons/Search_icon.png" />
            </span></h3>
                    <div id="validation_errors" ></div>
                    <div class="row expanded" id="filterSection" style="display: none;">
                        <div class="large-12 columns" >
                            <form accept-charset="utf-8" method="post" action="/tasks/dashboard_filter" id="filterTasksForm" >
                                <div class="row">
                                    <div class="large-12 columns">
                                        <fieldset>
                                            <div>
                                                <input type="radio" id="create_date"  name="date_filter" value="create_date" />
                                                <label for="create_date">Create Date</label>
                                                <br/>
                                                <input type="radio" id="start_date" checked="checked" name="date_filter" value="start_date" />
                                                <label for="start_date">Start Date</label>                                          
                                                <br/>
                                                <input type="radio" id="target_date" name="date_filter" value="target_date" />
                                                <label for="target_date">Target Date</label>
                                                <br/>
                                            </div>
                                        </fieldset>
                                    </div>      
                                </div>
                                <div class="row">
                                    <div class="large-6 columns">
                                        <label> Start Date From
                                            <input type="text" autocomplete="off" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
                                        </label>
                                    </div>
                                    <div class="large-6 columns">
                                        <label>
                                            Start Date To<input type="text" autocomplete="off" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-12 columns">
                                        <label>Keywords
                                            <input type="text" name="keyword" id="keyword" value="" />
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-12 columns">
                                        <br/>
                                        <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="dashboardContent">
                    <?php echo $dashboard_content; ?>
                </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/third_party/math.js" ></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="/js/tasks/dashboard.js" > </script>