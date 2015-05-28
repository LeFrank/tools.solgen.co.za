$(document).ready(function () {
    $('#expense_history').tablesorter();

    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    $("#filter").click(function () {
        $.post(
                "/expenses/filter-search",
                $("#filterExpenseForm").serialize()
                ).done(function (resp) {
            var source = $("#some-template").html();
            var template = Handlebars.compile(source);
            var total = 0.0;
            for (var i = 0; i < resp.length; i++) {
                var obj = resp[i];
                resp[i].payment_method_id = payment_methods[resp[i].payment_method_id].description;
                resp[i].expense_type_id = expense_types[resp[i].expense_type_id].description;
                total += parseFloat(obj.amount);
            }
            var data = {expenses: resp,
                total: total.toFixed(2)};
            $("#historyGraph").html(template(data));
            $('#expense_history').tablesorter();
        });
    });

    $("#expensePeriod").change(function () {
        if ($("#expensePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        }else{
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);
            
        }
    });

});
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i))
            continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));
        } else if (i == key && obj[key] == val) {
            objects.push(obj);
        }
    }
    return objects;
}