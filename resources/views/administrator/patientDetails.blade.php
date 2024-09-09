<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/administrator/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/administrator/patientDetails.css') }}">

        
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var chartData = JSON.parse(@json($data));
   
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Time');
            data.addColumn('number', 'Value');

            console.log('chartData:', chartData);
           
            chartData.forEach(function(row) {
                data.addRow([row.Time, row.Value]);
            });

          
            var options = {
                title: 'Overall State',
                curveType: 'none',
                legend: { position: 'bottom' },
                width: 700,
                height: 300,
                vAxis: {
                viewWindow: {
                min: 0 
                }
            }
        };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
      }
    </script>
    </head>
    <body>
        @include('administrator.adminSidebar')
        <div class="empty"></div>
        
        <div class="content">
            <p class="header">Patient Profile</p>
                <div class="main-content">
                    <div class="left-container">
                        <div class="user-info">
                            <div class="profile-group">
                                <div class="img-container">
                                    <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                </div>
                                <div class="profile-group-cntn">
                                    <p class="u-name">{{ $userDetails['name'] }}</p>
                                    <p class="u-email">{{ $userDetails['email'] }}</p>
                                    <p class="u-cond-head">Condition:</p>
                                    <p class="u-cond">{{ $userDetails['condition'] }}</p>
                                </div>
                                <div class="divider"> </div>
                                <div class="doc-list-container">
                                    @if(!empty($docData) && is_array($docData))
                                    <div class="doc-list-container">
                                        @foreach($docData as $index)
                                        <form method="GET" action="{{ route('viewdoctor', $index['id']) }}">
                                            @csrf
                                            <button class="doc-list" type="submit">
                                                @if(!empty($index['profile']))
                                                    <img src="{{ $index['profile'] }}">
                                                @else
                                                    <img src="{{ asset('assets/avatar.png') }}">
                                                @endif
                                                    <p class="doctor-name">{{ $index['name'] }}</p>
                                                    @if($index['status'] == 'approved')
                                                    <p class="approved">{{ $index['status'] }}</p>
                                                    @else
                                                    <p class="pending">{{ $index['status'] }}</p>
                                                    @endif
                                            </button><br>
                                        </form>
                                        @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="charts">
                            <p class="act-header">Activity</p>
                            <div id="curve_chart"></div>
                        </div>
                    </div>
                    <div class="right-container">
                        aaaa
                    </div>
                </div>
                
        </div>
    </body>
</html>