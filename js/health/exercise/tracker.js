    $(function () {
        $("#exerciseStartDate").datetimepicker();
        $("#exerciseEndDate").datetimepicker();
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
        CKEDITOR.replace('description');
        
        $("#exerciseType").click(function(){
            console.log($(this).find(":selected").attr("data-default_measurement_name"));
            var valu = $(this).find(":selected").attr("data-default_measurement_name");
            $("#measurement_value_label").text(valu);
        });
    });