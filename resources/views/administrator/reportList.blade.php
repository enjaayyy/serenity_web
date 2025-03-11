@extends('index')

@section('title', 'admin_report_lists')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/administrator/reportList.css')}}">
        <div>
            <div class="container">
                <div class="admin-header">
                        <p class="dash-text">Reports</p>
                        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
                </div>
                <div class="search-container">
                    <div class="input-container">
                        <img src="{{asset('assets/search-icon.svg') }}">
                        <input type="text" placeholder="Search Report" class="search-input"></input>
                        <img src="{{asset('assets/filter-icon.svg') }}">
                    </div>
                    <p>{{ $reportcount }}</p>
                </div>
                <div class="tickets-container">
                    @foreach($reports as $report)
                        <div class="ticket-details-container" id="ticket-details-container">
                            <p>Date Filed: {{$report['timestamp']}}</p>
                            <p class="reporter-name" id="reporter-name">Reporter: {{$report['reporter']}}</p>
                            <p>Reported: {{$report['reported']}}</p>
                            <textarea class="report-details" disabled>
                                {{$report['details']}}
                            </textarea>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <script src="{{ asset('js/utilities/searchReport.js') }}"></script>
@endsection