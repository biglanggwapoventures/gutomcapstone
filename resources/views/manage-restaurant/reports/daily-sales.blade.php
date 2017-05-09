@extends('manage-restaurant.layout', ['nav' => 'daily-sales'])

@section('form')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
				<h4><i class="fa fa-pie-chart fa-fw"></i> Daily Sales Report</h4>
			</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ asset('js/charts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var data = {!! json_encode($data) !!},
                dataSet = [],
                labels = []
            
            for(var x in data.details){
                var percentage = ((data.details[x] / data.summary) * 100).toFixed(0);
                dataSet.push(data.details[x])
                labels.push(x + ' ' + percentage +'%');
            }


            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                options: {
                    animation:{
                        animateScale:true
                    }
                },
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        // label: [2,3,4],
                        data: dataSet,
                        backgroundColor: [
                            "#FFCE56",
                            "#36A2EB",
                            "#FF6384",
                        ],
                        hoverBackgroundColor: [
                             "#FFCE56",
                            "#36A2EB",
                            "#FF6384",
                        ]
                    }]
                }
            });
        })
    </script>
@endpush