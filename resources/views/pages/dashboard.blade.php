<x-layout>

    <div class="box_model">
        <div class="dsh_row row">
            <div class="left_chart">
                <div class="dash_body">

                    <div class="chart-title__heading">
                        <div id="chart1" class="chart chart1">
                        </div>
                        <h3 class="chart-title">{{ __('sentence.my_sales') }}</h3>
                    </div>
                </div>
            </div>
            <div class="rt_box">
                <div class="vr_grid_box">
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.today_total_orders') }}</h3>
                        <label>{{ $todaysSale }} €.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.todays_sale') }}</h3>
                        <label>{{ $orders }} €.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>{{ __('sentence.last_7_days_sale') }}</h3>
                        <label>{{ $sevensSale }} €.</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            function createChart(elementId, type, series, categories, options = {}) {
                const defaultOptions = {
                    chart: {
                        type: type,
                        height: 300,
                        redrawOnParentResize: true,
                        redrawOnWindowResize: true,
                        toolbar: {
                            show: false,
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150,
                            },
                        },
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 10,
                            left: 0,
                            blur: 5,
                            opacity: 0.15,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            style: {
                                colors: "#666666",
                                fontSize: "13px",
                                fontFamily: "Roboto, sans-serif",
                                fontWeight: 500,
                            },
                        },
                        axisBorder: {
                            show: true,
                            color: '#dddddd',
                        },
                        axisTicks: {
                            show: true,
                            borderType: 'solid',
                            color: '#dddddd',
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: "#666666",
                                fontSize: "13px",
                                fontFamily: "Roboto, sans-serif",
                                fontWeight: 500,
                            },
                        },
                        title: {
                            text: '€ Value',
                            style: {
                                color: "#333333",
                                fontSize: "16px",
                                fontFamily: "Roboto, sans-serif",
                                fontWeight: 600,
                            },
                        },
                        axisBorder: {
                            show: false,
                        },
                        tickAmount: 6,
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val.toFixed(2) + " €";
                            },
                        },
                        theme: 'dark', // Dark themed tooltips for contrast
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Roboto, sans-serif',
                        },
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 4,
                    },
                    markers: {
                        size: 5,
                        colors: ["#ffffff"],
                        strokeColors: ["#FF4560", "#00E396"],
                        strokeWidth: 3,
                        hover: {
                            size: 8,
                        },
                    },
                    grid: {
                        borderColor: '#ebebeb',
                        strokeDashArray: 4,
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: 'horizontal',
                            gradientToColors: ['#FDD835', '#00E396'],
                            stops: [0, 100],
                        },
                    },
                    responsive: [{
                        breakpoint: 1600,
                        options: {},
                    }],
                };

                new ApexCharts(document.getElementById(elementId), {
                    ...defaultOptions,
                    series: series,
                    ...options
                }).render();
            }

            // Fetch and render the line chart for revenue
            $.ajax({
                url: "/get-chart-data",
                type: "GET",
                success: function(response) {
                    const revenue = response.data.map(item => item.total_profit);
                    const dates = response.data.map(item => item.date);
                    createChart('chart0', 'line', [{
                        name: "Revenue",
                        data: revenue,
                    }], dates);
                },
                error: function(error) {
                    console.log(error);
                },
            });

            // Fetch and render the line chart for sales and earnings
            $.ajax({
                url: "/get-chart-data-month",
                type: "GET",
                success: function(response) {
                    createChart('chart1', 'line', [{
                            name: "Vente",
                            data: response.data.sales
                        },
                        {
                            name: "Revenus",
                            data: response.data.profit
                        },
                    ], [
                        "{{ __('sentence.january') }}",
                        "{{ __('sentence.february') }}",
                        "{{ __('sentence.march') }}",
                        "avril",
                        "{{ __('sentence.may') }}",
                        "{{ __('sentence.june') }}",
                        "juillet",
                        "{{ __('sentence.august') }}",
                        "{{ __('sentence.september') }}",
                        "{{ __('sentence.october') }}",
                        "{{ __('sentence.november') }}",
                        "{{ __('sentence.december') }}",
                    ], {
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            fontSize: '14px',
                            fontFamily: 'Roboto, sans-serif',
                            fontWeight: 600,
                            labels: {
                                colors: '#525050',
                            },
                            markers: {
                                radius: 10,
                            },
                        },
                    });
                },
                error: function(error) {
                    console.log(error);
                },
            });
        </script>
    @endpush

</x-layout>
