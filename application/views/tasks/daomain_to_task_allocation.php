<?php ?>
<script type="text/javascript" src="/js/third_party/toastr/toastr.min.js" ></script>
<script type="text/javascript" src="/js/third_party/toastr/glimpse.js" ></script>
<script type="text/javascript" src="/js/third_party/toastr/glimpse.toastr.js" ></script>
<script>
    toastr.options = {
        closeButton: true,
        onclick: null
    };

    let domain_placeholder_string = "drag_point_domain_";
    let task_tile_placeholder_string = "drag"

    function droppoint(event) {
        event.preventDefault();
        var data = event.dataTransfer.getData("text/plain");
        drop_point_id = event.target.id;
        task_id = data.replace(task_tile_placeholder_string, "");
        domain_id = drop_point_id.replace(domain_placeholder_string, "");
        // console.log(data);
        // console.log($(event));
        event.target.appendChild(document.getElementById(data));
        // console.log("drop point: " + event.target.id);
        // console.log("Domain-id: " + domain_id);
        record_task_domain_shift(task_id  ,domain_id);
    }

    function allowDropOption(event) {
        event.preventDefault();
    }

    function dragpoint(event) {
        event.dataTransfer.setData("text/plain", event.target.id);
        // console.log($(this).val());
    }


    function record_task_domain_shift(task_id, target_domain_id){
        console.log("Task #: " + task_id +" will move to domain_id: " + target_domain_id);
        $.post(
            "/tasks/task/"+task_id+"/shift-domain/" + target_domain_id,
        ).done(function (resp) {
            //worked, so animate to show success
            let resp_value = JSON.parse(resp);
            if(resp_value["status"] == "success"){
                toastr.success(resp_value["message"]);
                // $("#row_"+task_id).css({"background-color": "#c5f4b8", "color": "#007502"});
            } else {
                toastr.error(resp_value["message"]);
            }
        }).error(function (xhr, textStatus, errorThrown){
            // alert('request failed');
            toastr.error("Error: " + xhr.status+ " => " + errorThrown);
            console.log(xhr);
        });
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