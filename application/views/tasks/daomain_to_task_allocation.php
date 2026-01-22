<?php ?>
<script>
    function droppoint(event) {
        event.preventDefault();
        var data = event.dataTransfer.getData("text/plain");
        console.log(data);
        console.log($(event).);
        event.target.appendChild(document.getElementById(data));
    }

    function allowDropOption(event) {
        event.preventDefault();
    }

    function dragpoint(event) {
        event.dataTransfer.setData("text/plain", event.target.id);
        
    }
</script>

<div class="row expanded">
    <div class="large-12 columns" >
        <h1>Tasks To Domain Allocation             <span id="searchExpand"><img src="/images/third_party/icons/Search_icon.png" />
            </span></h3>
                    <div id="validation_errors" ></div>
                    <div class="row expanded" id="filterSection" style="display: none;">
                        <div class="large-12 columns" >
                            <form accept-charset="utf-8" method="post" action="/tasks/domain_to_task_filter" id="domain_to_task_filter_form" >
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
                <div id="domain_to_task_allocation_content">
                    <?php echo $domain_to_task_allocation_content; ?>
                </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/third_party/math.js" ></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="/js/tasks/domain_to_task_allocation.js" > </script>