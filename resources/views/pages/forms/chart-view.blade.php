@extends('master')

@push('css')
    <style>
        .container {
            margin-top: 3rem;
        }
        .chart-container {
            width: 100%;
            margin: 1rem;
            position: relative;
        }
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .chart-label {
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .no-data-message {
            font-size: 1.5em;
            text-align: center;
            color: #666;
            margin-top: 4rem;
            font-weight: bold;
        }
        @media(min-width: 768px) {
            .chart-container {
                width: 30%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row" id="charts"></div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2/dist/chartjs-plugin-datalabels.min.js"></script>

    <script>
        let rawData = {!! $output !!};
        let container = document.getElementById('charts');

        if (rawData.length === 0) {
            let messageDiv = document.createElement('div');
            messageDiv.className = 'no-data-message';
            messageDiv.innerHTML = '<h3>No data available. Awaiting first submission.</h3>';
            container.appendChild(messageDiv);
        } else {
            rawData.forEach((data) => {
                let chartDiv = document.createElement('div');
                chartDiv.className = 'chart-container';

                let card = document.createElement('div');
                card.className = 'card';
                chartDiv.appendChild(card);

                let label = document.createElement('div');
                label.className = 'chart-label card-header';
                label.innerHTML = data.question;
                card.appendChild(label);

                let canvas = document.createElement('canvas');
                canvas.id = 'myPieChart' + data.question;
                let cardBody = document.createElement('div');
                cardBody.className = 'card-body';
                cardBody.appendChild(canvas);
                card.appendChild(cardBody);

                container.appendChild(chartDiv);

                let ctx = canvas.getContext('2d');
                let questions = Object.keys(data.answers);
                let values = Object.values(data.answers);

                let backgroundColors = [
                    'rgba(15,206,15,0.2)', 'rgba(0, 0, 255, 0.2)',
                    'rgba(255,0,0,0.2)', 'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
                    'rgba(128, 0, 128, 0.2)', 'rgba(255, 165, 0, 0.2)',
                    'rgba(255, 99, 132, 0.2)', 'rgba(255, 192, 203, 0.2)'
                ];

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: questions,
                        datasets: [{
                            label: 'Responses',
                            data: values,
                            backgroundColor: backgroundColors
                        }]
                    },
                    plugins: [ChartDataLabels], // Add this line
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            datalabels: {
                                color: '#fff',
                                formatter: function (value, ctx) {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    let percentage = (value * 100 / sum).toFixed(2) + "%";
                                    return percentage;
                                },
                                font: {
                                    weight: 'bold',
                                    size: 16,
                                }
                            }
                        }
                    }
                });
            });
        }
    </script>
@endpush
