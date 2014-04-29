$(document).ready(function() {
    $('#expense_history').tablesorter();

    $(function() {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    $("#filter").click(function() {
        $.post(
                "/expenses/filter-search",
                $("#filterExpenseForm").serialize()
                ).done(function(resp) {
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
});
