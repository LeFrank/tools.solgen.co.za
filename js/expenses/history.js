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
        } else {
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);

        }
    });

});
// request permission on page load
document.addEventListener('DOMContentLoaded', function () {
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

function notifyMe() {
    var dts = moment().add(5, 'm').unix();
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
        return;
    }

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification('Notification title', {
            icon: 'http://cdn.sstatic.net/stackexchange/img/logos/so/so-icon.png',
            body: "Hey there! You've been notified!",
            timestamp: dts
        });

        notification.onclick = function () {
            window.open("http://stackoverflow.com/a/13328397/1269037");
        };

    }
    var formattedTime = formatTime(dts);
    console.log(formattedTime);
}
var formatTime = function(unixTimestamp) {
    var dt = new Date(unixTimestamp * 1000);

    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (hours < 10) 
     hours = '0' + hours;

    if (minutes < 10) 
     minutes = '0' + minutes;

    if (seconds < 10) 
     seconds = '0' + seconds;

    return hours + ":" + minutes + ":" + seconds;
}       