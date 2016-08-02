/**
 * Created by Owner on 6/28/2016.
 */

var highcharts_income = {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Retirement Income'
    },
    xAxis: {
        min: income_x_axis_min,
        max: income_x_axis_max,
        tickInterval: 10,

    },
    plotOptions: {
        series: {
            animation: false
        }
    },
    yAxis: {
        min: income_y_axis_min,
        max: income_y_axis_max
    },

    labels: {
        items: [{
            /*html: '',*/
            style: {
                left: '50px',
                top: '18px',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
            }
        }]
    },
    tooltip: {
        shared: true,
        crosshairs: true
    },
    series: income_series,
    exporting: {
        chartOptions: { // specific options for the exported image
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true
                    }
                }
            }
        },
        scale: 3,
    }
};

var highcharts_investments =  {
                    chart: {
                        zoomType: 'xy',
                    },
                    title: {
                        text: 'Retirement Investments'
                    },
                    plotOptions: {
                        area: {
                            stacking: 'normal',
                            lineColor: '#666666',
                            lineWidth: 1,
                            marker: {
                                lineWidth: 1,
                                lineColor: '#666666'
                            }
                        },
                        series: {
                            animation: false
                        }
                    },
                    xAxis: {
                        min: investment_x_axis_min,
                        max: investment_x_axis_max,
                        /*tickInterval: 10,*/

                    },
                    tooltip: {
                        shared: true,
                        crosshairs: true
                    },
                    yAxis: {
                        min: investment_y_axis_min,
                        max: investment_y_axis_max
                    },
                    series: investment_series,
                exporting: {
                    chartOptions: { // specific options for the exported image
                        plotOptions: {
                            series: {
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        }
                    },
                    scale: 3,
                }

    }


$( document ).ready(function() {

    interval = 0
    $("#chart-container-income").highcharts(highcharts_income);
    $("#chart-container-investment").highcharts(highcharts_investments);

    $('.idealsteps-nav').click(function(){
        if(interval == 0){
            console.time('area');
            $("#chart-container-income").highcharts(highcharts_income);
            $("#chart-container-investment").highcharts(highcharts_investments);
            console.timeEnd('area');
            interval = 1;
        }
    });


});


