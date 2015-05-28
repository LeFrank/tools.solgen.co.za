$(document).ready(function () {
    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });
    $("#filter").click(function () {
        $.post(
                "/notes/stats",
                {"fromDate": $("#fromDate").val(), "toDate": $("#toDate").val()}
        ).done(function (resp) {
            $("#notes-stats-content").replaceWith(resp);
        });
    });

    //Hours when expenses are produced
    var plot3 = $.jqplot('notes-per-hour-over-period', [amount, noteCount], {
        title: 'Hour of day break down',
        seriesDefaults: {
            //renderer: $.jqplot,
            rendererOptions: {
                highlightMouseOver: true,
                barWidth: 10
            }
        },
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                tickOptions: {
                    angle: 45,
                },
                ticks: hours
            },
            yaxis: {
                label: 'Cummulative Amount',
                //renderer: $.jqplot.LogAxisRenderer
            },
            y2axis: {
                label: '# of notes',
            }
        },
        highlighter: {
                    show: true,
                    sizeAdjust: 7.5
              },
        series: [
            {yaxis: 'yaxis', label: 'Amount of Characters'},
            {yaxis: 'y2axis', label: 'Number of Notes'}

        ]
    });
});