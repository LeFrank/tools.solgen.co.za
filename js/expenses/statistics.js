$(document).ready(function() {
    var url = window.location.href
    var arr = url.split("/");
    $(function() {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });

    //expense types totals
    $.jqplot.config.enablePlugins = true;
    plot0 = $.jqplot('expense-type-totals', [expenseTotals], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesDefaults: {
            renderer: $.jqplot.BarRenderer,
            showMarker: true,
            rendererOptions: {
                // Set the varyBarColor option to true to use different colors for each bar.
                // The default series colors are used.
                varyBarColor: true
            },
            pointLabels: {show: true}
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: expenseTotalNames,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    angle: 10
                }
            },
            yaxis: {
                min: 0,
                max: max,
                numberTicks: 10
            }
        },
        highlighter: {
            renderer: $.jqplot.CategoryAxisRenderer,
            show: true}
    });

$.jqplot.config.enablePlugins = true;
    plot01 = $.jqplot('payment-method-totals', [paymentMethodTotals], {
        // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
        animate: !$.jqplot.use_excanvas,
        seriesDefaults: {
            renderer: $.jqplot.BarRenderer,
            showMarker: true,
            rendererOptions: {
                // Set the varyBarColor option to true to use different colors for each bar.
                // The default series colors are used.
                varyBarColor: true
            },
            pointLabels: {show: true}
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: paymentMethodTotalsNames,
                tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                tickOptions: {
                    angle: 10
                }
            },
            yaxis: {
                min: 0,
                max: paymentMethodTotalMax,
                numberTicks: 10
            }
        },
        highlighter: {
            renderer: $.jqplot.CategoryAxisRenderer,
            show: true}
    });

    $('#chart1').bind('jqplotDataClick',
        function(ev, seriesIndex, pointIndex, data) {
            $('#info1').html('series: ' + seriesIndex + ', point: ' + pointIndex + ', data: ' + data);
        }
    );

    $('#expense-type-totals').bind('jqplotDataClick',
        function(ev, seriesIndex, pointIndex, data) {
            var url = arr[0] + "://" + window.location.host + "/expenses/getExpenses/" + expenseTypeIdsForTotals[pointIndex] + "?keepThis=true&TB_iframe=true&width=850&height=500";
            tb_show("Expenses", url);
        }
    );
    
    $('#payment-method-totals').bind('jqplotDataClick',
        function(ev, seriesIndex, pointIndex, data) {
            var url = arr[0] + "://" + window.location.host + "/expenses/getExpenses/" + paymentMethodIdsForTotals[pointIndex] + "?keepThis=true&TB_iframe=true&width=850&height=500";
            tb_show("Expenses", url);
        }
    );



    // Expenses over period
    var plot1 = $.jqplot('expenses-over-time-period', [line1], {
        title: 'Expense Over The Time Period',
        axes: {
            xaxis: {
                renderer: $.jqplot.DateAxisRenderer,
                tickOptions: {
                    formatString: '%b&nbsp;%#d'
                }
            },
            yaxis: {
                tickOptions: {
                    formatString: '%.2f'
                }
            }
        },
        highlighter: {
            show: true,
            sizeAdjust: 7.5
        },
        cursor: {
            show: false
        }
    });

    // Days on which expenses happen
    var plot2 = jQuery.jqplot('days-on-which-expenses-were-made', [dayOfWeekData],
            {
                title: 'Day of the week break down',
                seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer,
                    rendererOptions: {
                        // Turn off filling of slices.
                        fill: false,
                        showDataLabels: true,
                        //dataLabels: dayExpenseslabels,
                        // Add a margin to seperate the slices.
                        sliceMargin: 4,
                        // stroke the slices with a little thicker line.
                        lineWidth: 3
                    }
                },
                legend: {show: true, location: "outsideGrid"}
            }
    );
    /* CLICK CODE START*/
    $('#days-on-which-expenses-were-made').bind('jqplotDataClick',
            function(ev, seriesIndex, pointIndex, data) {
                var url = arr[0] + "://" + window.location.host + "/expenses/getExpenses/" + expenseIdsForDayOfWeek[pointIndex] + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
    );

    $('#expenses-over-time-period').bind('jqplotDataClick',
            function(ev, seriesIndex, pointIndex, data) {
                var url = arr[0] + "://" + window.location.host + "/expenses/getExpenses/" + allExpenses[pointIndex].id + "?keepThis=true&TB_iframe=true&width=850&height=500";
                tb_show("Expenses", url);
            }
    );
    /* CLICK CODE END*/



    //Hours when expenses are produced
    var plot3 = $.jqplot('expenses-per-hour-over-period', [amount, expenseCount], {
        title: 'Hour of day break down',
        seriesDefaults: {
            //renderer: $.jqplot,
            rendererOptions: {
                highlightMouseOver: true,
                barWidth: 10
            }
        },
//        legend: {
//            show: true,
//            placement: 'outsideGrid'
//        },
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
                label: '# of expenses',
            }
        },
        highlighter: {
                    show: true,
                    sizeAdjust: 7.5
              },
        series: [
            {yaxis: 'yaxis', label: 'Amount Value'},
            {yaxis: 'y2axis', label: 'Number of Expenses'}

        ]
    });
    
    $("#expensePeriod").change(function () {
//        console.log("Chenged");
        if ($("#expensePeriod").val() == "0") {
            $("#fromDate").val(default_start_date);
            $("#toDate").val(default_end_date);
        }else{
            var selectedObj = getObjects(expense_period, "id", $("#expensePeriod").val());
//            console.log(selectedObj);
            $("#fromDate").val(selectedObj[0]["start_date"]);
            $("#toDate").val(selectedObj[0]["end_date"]);
            
        }
    });
    
    
    $('#expenses_rollup').tablesorter();
});


    var plot4 = jQuery.jqplot('payment-method-totals-pie', [expenseValueByMethodOfPayment],
            {
                title: 'Expense Payment Method Totals',
                seriesDefaults: {
                    renderer: jQuery.jqplot.PieRenderer,
                    rendererOptions: {
                        // Turn off filling of slices.
                        fill: false,
                        showDataLabels: true,
                        //dataLabels: dayExpenseslabels,
                        // Add a margin to seperate the slices.
                        sliceMargin: 4,
                        // stroke the slices with a little thicker line.
                        lineWidth: 3
                    }
                },
                legend: {show: true, location: 'e'}
            }
    );